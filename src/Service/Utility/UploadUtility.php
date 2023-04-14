<?php

namespace App\Service\Utility;


use App\Entity\Exception\UnknownPermissionTypeException;

use App\Entity\InternalUser;
use App\Entity\Invitation;
use App\Entity\InvitationGroup;
use App\Entity\Invitee;
use App\Entity\Permission;

//use App\Repository\CategoryRepository;
use App\Entity\Role;
use App\Entity\User;
use App\Repository\InternalUserRepository;
use App\Repository\PermissionRepository;
use App\Repository\RoleRepository;
use App\Security\AccessControl\Exception\RoleAlreadyHasPermissionAssignedException;
//use App\Service\Domain\Entity\CategoryDataTransferObject;
use App\Service\Domain\Entity\PermissionDataTransferObject;
use App\Service\Domain\Entity\RoleDataTransferObject;
use App\Service\Domain\Entity\UserDataTransferObject;
use App\Service\Domain\Exception\MissingAttributeException;
use App\Service\Domain\InviteeService;
use App\Service\Service;
use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UploadUtility extends Service
{

    /**
     * @var InviteeService
     */
    private InviteeService $inviteeService;

    /**
     * @var string
     */
    private string $uploadsDir;

    /**
     * @var UserDataTransferObject
     */
    private UserDataTransferObject $userDataTransferObject;
    private const IMPORTED_INVITEES_DIR = '/imports/invitees/';
    private const EXPORTED_INVITEES_DIR = '/exports/invitees/';

//$person['userGroup'] === $invitee['userGroup'] &&
//$person['invitationType'] === $invitee['invitationType'] &&
//$person['firstname'] !== $invitee['firstname']

    /**
     * @param array $groupedAllData
     * @param array $allData
     * @param array $invitee
     * @return void
     */
    private function assignToGroup( array &$groupedAllData, array $allData, array $invitee )
    {
        $newGroup = [];
            foreach ($allData as $person){
                    if (
                        $person['userGroup'] === $invitee['userGroup'] &&
                        $person['invitationType'] === $invitee['invitationType']
                    ) {
                        if (!$this->personExistsInGroup($newGroup, $person))
                            $newGroup[] = $person;

                        if (!$this->personExistsInGroup($newGroup, $invitee))
                            $newGroup[] = $invitee;
                    }
            }

        if ( ! $this->groupExists($groupedAllData, $newGroup) )
            $groupedAllData[] = $newGroup;
    }

    /**
     * @param array $group
     * @param array $person
     * @return bool
     */
    private function personExistsInGroup( array $group, array $person ): bool
    {
        foreach ( $group as $invitee )
            if ( $person === $invitee )
                return true;

        return false;
    }

    /**
     * @param array $allGroups
     * @param array $group
     * @return bool
     */
    private function groupExists( array $allGroups, array $group ): bool
    {
        foreach ( $allGroups as $allGroup )
            foreach ( $allGroup as $person )
                foreach ( $group as $invitee )
                    if ( $person === $invitee )
                        return true;

        return false;
    }


    public function __construct
        (
            EntityManagerInterface $entityManager,
            EventDispatcherInterface $eventDispatcher,
            InviteeService $inviteeService,
            LoggerInterface $logger,
            RequestStack $session,
            $uploadsDir,
            UserDataTransferObject $userDataTransferObject
        )
    {
        $this->inviteeService = $inviteeService;
        $this->uploadsDir = $uploadsDir;
        $this->userDataTransferObject = $userDataTransferObject;

        parent::__construct($entityManager, $eventDispatcher, $logger, $session);
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return UploadedFile
     */
    public function uploadFile(UploadedFile $uploadedFile): UploadedFile
    {
        $uploadDir = $this->uploadsDir.static::IMPORTED_INVITEES_DIR;
//        $date = new \DateTime('now');
//        $dateString = $date->format('Y-m-d');
        $fileName = 'invitees' . '.' . $uploadedFile->guessExtension();

        $uploadedFile->move(
            $uploadDir,
            $fileName
        );

        return $uploadedFile;
    }

    /**
     * @param User $user
     * @return void
     * @throws MissingAttributeException
     * @throws \App\Entity\Exception\EntityNotCreatedException
     * @throws \App\Entity\Exception\InvitationNotCreatedException
     * @throws \App\Entity\Exception\UnknownUserTypeException
     * @throws \App\Service\Domain\Exception\InviteeWithDuplicateUsernameException
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\Exception
     */
    public function importInvitees(User $user): void
    {
        $uploadDir = $this->uploadsDir.static::IMPORTED_INVITEES_DIR;
        $fileName = 'invitees.txt';
        $inputInvitees = $uploadDir . $fileName;

        $decoder = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

        $xlRows = $decoder->decode(file_get_contents($inputInvitees), 'csv');

        $allData = [];

        foreach ($xlRows as $row) {
            $dataPerson = [];

            foreach ($row as $invitee) {
                $valueHolder = $invitee;
                $delimiter = ";";

                $delimiterPos = strpos($valueHolder, $delimiter);
                $firstname = substr($valueHolder, 0, $delimiterPos);
                $valueHolder = substr($valueHolder, $delimiterPos + 1);

                $delimiterPos = strpos($valueHolder, $delimiter);
                $lastname = substr($valueHolder, 0, $delimiterPos);
                $valueHolder = substr($valueHolder, $delimiterPos + 1);

                $delimiterPos = strpos($valueHolder, $delimiter);
                $title = substr($valueHolder, 0, $delimiterPos);
                $valueHolder = substr($valueHolder, $delimiterPos + 1);

                $delimiterPos = strpos($valueHolder, $delimiter);
                $invitationGroup = substr($valueHolder, 0, $delimiterPos);

                $inviteeFrom = substr($valueHolder, $delimiterPos + 1);

                $dataPerson['username'] = InvitationGroup::generateRandomAlias(
                    md5(uniqid($firstname.$lastname))
                );

                $dataPerson['author'] = $user;

                $dataPerson['firstname'] = $firstname;

                $dataPerson['lastname'] = $lastname;

                $dataPerson['title'] = $title;

                if (str_contains(strtolower($invitationGroup), 's')) {
                    $dataPerson['invitationType'] = 1;
                    $dataPerson['userGroup'] = null;
                }

                if (str_contains(strtolower($invitationGroup), 'c')){
                    $dataPerson['invitationType'] = 2;
                    $dataPerson['userGroup'] = substr($invitationGroup, strpos($invitationGroup, 'e')+1);
                }

                if (str_contains(strtolower($invitationGroup), 'm')){
                    $dataPerson['invitationType'] = 4;
                    $dataPerson['userGroup'] = substr($invitationGroup, strpos($invitationGroup, 'd')+1);
                }


                if (str_contains(strtolower($invitationGroup), 'f')) {
                    $dataPerson['invitationType'] = 3;
                    $dataPerson['userGroup'] = substr($invitationGroup, strpos($invitationGroup, 'm')+1);
                }

                $dataPerson['phoneNumber'] = null;

                $dataPerson['email'] = null;

                switch (strtolower($inviteeFrom)){
                    case 'g':
                    {
                        $dataPerson['invFrom'] = Invitee::INVITEE_FROM_GROOM;
                        break;
                    }
                    default: {
                        $dataPerson['invFrom'] = Invitee::INVITEE_FROM_BRIDE;
                        break;
                    }
                }
            }
            $allData[] = $dataPerson;
        }

        $groupedAllData = [];
        foreach ($allData as $key => $datum){
            $newGroup = [];
            if($datum['invitationType'] !== 1)
                $this->assignToGroup($groupedAllData, $allData, $datum);
            else
                $newGroup[] = $datum;

            if (! empty( $newGroup ) )
                $groupedAllData[] = $newGroup;
        }

        foreach ( $groupedAllData as $group )
            $this->inviteeService->createInvitee($group);
    }
}
<?php

namespace App\Service\Utility;


use App\Entity\Chain;
use App\Entity\Column;
use App\Entity\Content;
use App\Entity\Exception\UnknownPermissionTypeException;

use App\Entity\ExternalUser;
use App\Entity\InternalActivity;
use App\Entity\InternalUser;
use App\Entity\Navigation;
use App\Entity\Page;
use App\Entity\Permission;

use App\Entity\Role;
use App\Entity\Section;
use App\Repository\AbstractPageRepository;
use App\Repository\ContentKindRepository;
use App\Repository\ExternalUserRepository;
use App\Repository\InternalActivityRepository;
use App\Repository\InternalUserRepository;
use App\Repository\PageRepository;
use App\Repository\PermissionRepository;
use App\Repository\RoleRepository;
use App\Repository\SectionRepository;
use App\Service\Domain\Entity\ContentKindDataTransferObject;
use App\Service\Domain\Entity\PermissionDataTransferObject;
use App\Service\Domain\Entity\RoleDataTransferObject;
use App\Service\Domain\Exception\MissingAttributeException;
use App\Service\Service;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ImportUtility extends Service
{
    /**
     * @var ContentKindDataTransferObject
     */
    private ContentKindDataTransferObject $contentKindDataTransferObject;

    /**
     * @var ContentKindRepository
     */
    private ContentKindRepository $contentKindRepository;

    /**
     * @var ExternalUserRepository
     */
    private ExternalUserRepository $externalUserRepository;

    /**
     * @var InternalActivityRepository
     */
    private InternalActivityRepository $internalActivityRepository;

    /**
     * @var InternalUserRepository
     */
    private InternalUserRepository $internalUserRepository;

    /**
     * @var AbstractPageRepository
     */
    private AbstractPageRepository $abstractPageRepository;

    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $userPasswordHasher;

    /**
     * @var PermissionDataTransferObject
     */
    private PermissionDataTransferObject $permissionDataTransferObject;

    /**
     * @var PermissionRepository
     */
    private PermissionRepository $permissionRepository;

    /**
     * @var RoleDataTransferObject
     */
    private RoleDataTransferObject $roleDataTransferObject;

    /**
     * @var RoleRepository
     */
    private RoleRepository $roleRepository;

    /**
     * @var SectionRepository
     */
    private SectionRepository $sectionRepository;

    private const ROLE_INTERNAL_ADMIN = 'Internal Admin';
    private const ROLE_INTERNAL_EDITOR = 'Internal Editor';
    private const ROLE_INTERNAL_VIEWER = 'Internal Viewer';
    private const ROLE_SUPER_ADMIN = 'Super Admin';
    private const ROLE_EXTERNAL_USER = 'External User';

    private const EXTERNAL_USER_TEST = 'danmjrn@gmail.com';
    private const SUPER_ADMIN_1 = 'danieljrnkulu@shapeit.solutions';
//    private const SUPER_ADMIN_2 = 'alex@shapeit.solutions';
//    private const INTERNAL_USER_1 = 'scola@shapeit.solutions';
//    private const INTERNAL_USER_2 = 'viewer@shapeit.solutions';


    /**
     * @param Permission $permission
     * @return Permission|null
     */
    private function createPermission(Permission $permission): ?Permission
    {
        $this->saveEntity($permission);

        return $permission;
    }

    public function __construct
        (
            ContentKindDataTransferObject $contentKindDataTransferObject,
            ContentKindRepository $contentKindRepository,
            EntityManagerInterface $entityManager,
            EventDispatcherInterface $eventDispatcher,
            ExternalUserRepository $externalUserRepository,
            LoggerInterface $logger,
            RequestStack $requestStack,
            InternalActivityRepository $internalActivityRepository,
            InternalUserRepository $internalUserRepository,
            UserPasswordHasherInterface $userPasswordHasher,
            AbstractPageRepository $abstractPageRepository,
            PermissionDataTransferObject $permissionDataTransferObject,
            PermissionRepository $permissionRepository,
            RoleDataTransferObject $roleDataTransferObject,
            RoleRepository $roleRepository,
            SectionRepository $sectionRepository
        )
    {
        $this->contentKindDataTransferObject = $contentKindDataTransferObject;
        $this->contentKindRepository = $contentKindRepository;
        $this->externalUserRepository = $externalUserRepository;
        $this->internalActivityRepository = $internalActivityRepository;
        $this->internalUserRepository = $internalUserRepository;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->abstractPageRepository = $abstractPageRepository;
        $this->permissionDataTransferObject = $permissionDataTransferObject;
        $this->permissionRepository = $permissionRepository;
        $this->roleDataTransferObject = $roleDataTransferObject;
        $this->roleRepository = $roleRepository;
        $this->sectionRepository = $sectionRepository;

        parent::__construct($entityManager, $eventDispatcher, $logger, $requestStack);
    }

    /**
     * @return void
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function createUserAccounts(): void
    {
        $internalUser1 = $this->internalUserRepository->findByEmail(static::SUPER_ADMIN_1);

        if (is_null($internalUser1)) {
            $internalUser1 = new InternalUser();

            $hashedPassword = $this->userPasswordHasher->hashPassword($internalUser1, 'TempPass1234!');

            $internalUser1
                ->setEmail(static::SUPER_ADMIN_1)
                ->setFirstname('Daniel Jr')
                ->setIsDeleted(false)
                ->setIsVerified(true)
                ->setLastname('Nkulu')
                ->setPassword($hashedPassword)
                ->setUsername(static::SUPER_ADMIN_1)
            ;

            $role = $this->roleRepository->findByName(static::ROLE_SUPER_ADMIN);

            if (! is_null($role))
                $internalUser1->assignRole($role);

            $internalActivity = $this->internalActivityRepository->findByTitle('Initial Super User');

            if(is_null($internalActivity)){
                $internalActivity = new InternalActivity();

                $internalActivity
                    ->setTitle('Initial Super User')
                    ->setDescription('Initializing System with super user')
                    ->setInternalUser($internalUser1)
                ;

                $this->persistEntity($internalActivity);
            }

            $internalUser1->setInternalActivity($internalActivity);


            $this->persistEntity($internalUser1);
        }

        $externalUserTest = $this->externalUserRepository->findByEmail(static::EXTERNAL_USER_TEST);

        if (is_null($externalUserTest)) {
            $externalUserTest = new ExternalUser();

            $hashedPassword = $this->userPasswordHasher->hashPassword($externalUserTest, 'P@ssword1!');

            $externalUserTest
                ->setEmail(static::EXTERNAL_USER_TEST)
                ->setFirstname('Daniel Junior')
                ->setIsDeleted(false)
                ->setIsVerified(true)
                ->setLastname('Nkulu')
                ->setPassword($hashedPassword)
                ->setUsername(static::EXTERNAL_USER_TEST)
            ;

            $role = $this->roleRepository->findByName(static::ROLE_EXTERNAL_USER);

            if (! is_null($role))
                $externalUserTest->assignRole($role);

            $this->persistEntity($externalUserTest);
        }

        $this->flush();
    }

    /**
     * @return void
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function importContentKinds(): void
    {
        $kinds =
            [
                'image' => 'An HTML tag used to insert images into a web page. It is written in the following format: <img src="image.jpg" alt="My Image" />',
                'video' => 'An HTML element used to embed video content into a web page. It is represented by the <video> tag and is written in the following format: <video src="video.mp4" width="320" height="240"></video>',
                'link' => 'An HTML element used to create a hyperlink to another web page or resource. It typically consists of an anchor tag enclosing the URL of the target resource. It is written in the following format: <a href="https://www.google.com">Google</a>',
                'heading1' => 'A HTML element used to define the main heading of a webpage or section, and is represented by the <h1> tag. It is written in the following format: <h1>My Heading</h1>',
                'heading2' => 'A heading2 tag is used in HTML to define a second-level heading on a webpage, and is represented by the <h2> tag. It is written in the following format: <h2>My Heading</h2>',
                'heading3' => 'A heading3 tag is used in HTML to define a third-level heading on a webpage, and is represented by the <h3> tag. It is written in the following format: <h3>My Heading</h3>',
                'heading4' => 'A heading4 tag is used in HTML to define a fourth-level heading on a webpage, and is represented by the <h4> tag. It is written in the following format: <h4>My Heading</h4>',
                'heading5' => 'A heading5 tag is used in HTML to define a fifth-level heading on a webpage, and is represented by the <h5> tag. It is written in the following format: <h5>My Heading</h5>',
                'heading6' => 'A heading6 tag is used in HTML to define a sixth-level heading on a webpage, and is represented by the <h6> tag. It is written in the following format: <h6>My Heading</h6>',
                'paragraph' => 'A HTML element used to define a paragraph of text, and is represented by the <p> tag. It is written in the following format: <p>My Paragraph</p>',
                'list' => 'A HTML element used to define an unordered list of items, and is represented by the <ul> tag. It is written in the following format: <ul><li>Item 1</li><li>Item 2</li></ul>',
                'ordered_list' => 'A HTML element used to define an ordered list of items, and is represented by the <ol> tag. It is written in the following format: <ol><li>Item 1</li><li>Item 2</li></ol>',
                'table' => 'A HTML element used to define a table of data, and is represented by the <table> tag. It is written in the following format: <table><tr><th>Column 1</th><th>Column 2</th></tr><tr><td>Row 1</td><td>Row 2</td></tr></table>',
                'select' => 'A HTML element used to define a drop-down list of options, and is represented by the <select> tag. It is written in the following format: <select><option>Option 1</option><option>Option 2</option></select>',
                'textarea' => 'A HTML element used to define a multi-line text input control, and is represented by the <textarea> tag. It is written in the following format: <textarea>My Text</textarea>',
                'input' => 'A HTML element used to define a single-line text input control, and is represented by the <input> tag. It is written in the following format: <input type="text" value="My Text" />',
                'button' => 'A HTML element used to define a clickable button, and is represented by the <button> tag. It is written in the following format: <button>My Button</button>',
                'form' => 'A HTML element used to define an HTML form for user input, and is represented by the <form> tag. It is written in the following format: <form><input type="text" value="My Text" /></form>',
                'iframe' => 'A HTML element used to embed an external web page into a web page, and is represented by the <iframe> tag. It is written in the following format: <iframe src="https://www.google.com"></iframe>',
                'audio' => 'A HTML element used to embed an audio file into a web page, and is represented by the <audio> tag. It is written in the following format: <audio src="audio.mp3"></audio>',
                'embed' => 'A HTML element used to embed an external web page into a web page, and is represented by the <embed> tag. It is written in the following format: <embed src="https://www.google.com"></embed>',
                'object' => 'A HTML element used to embed an external web page into a web page, and is represented by the <object> tag. It is written in the following format: <object data="https://www.google.com"></object>',
                'svg' => 'A HTML element used to embed an external web page into a web page, and is represented by the <svg> tag. It is written in the following format: <svg data="https://www.google.com"></svg>',
                'canvas' => 'A HTML element used to embed an external web page into a web page, and is represented by the <canvas> tag. It is written in the following format: <canvas data="https://www.google.com"></canvas>',
                'map' => 'A HTML element used to embed an external web page into a web page, and is represented by the <map> tag. It is written in the following format: <map data="https://www.google.com"></map>',
                'html' => 'A HTML element used to embed an external web page into a web page, and is represented by the <html> tag. It is written in the following format: <html data="https://www.google.com"></html>',
                'blockquote' => 'A HTML element used to embed an external web page into a web page, and is represented by the <blockquote> tag. It is written in the following format: <blockquote></blockquote>',
                'span' => 'A HTML element used to embed an external web page into a web page, and is represented by the <span> tag. It is written in the following format: <span></span>',
            ];

        try {
            foreach ($kinds as $type => $description) {
                if (! empty( $type ) ) {
                    $contentKind = $this->contentKindRepository->findByType($type);

                    if ( is_null( $contentKind ) ) {
                        $contentKind = $this->contentKindDataTransferObject->toEntity
                            (
                                [
                                    'type' => $type,
                                    'description' => $description,
                                ]
                            );

                        $this->persistEntity($contentKind);
                    }
                }
            }

            $this->flush();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\DBAL\Exception
     * @throws \Exception
     */
    public function importDefaultPages(): void
    {
        $this->beginTransaction();

        $navigationSlug = 'accuiel';
        $homePage = $this->abstractPageRepository->findAbstractPageByNavigationSlug($navigationSlug);

        if ( is_null( $homePage ) ) {
            $homePage = new Page();

            $homePage
                ->setTitle('Accuiel')
                ->setDescription('Welcome Page | Official Site: BETRATEC SARL,BETRATEC SARL helps you design and build your dream, CIVIL ENGINEERING,ELECTRICAL SERVICE,MECHANICAL,Waste Management')
                ->setTags('betratec sarl, civil engineering, electrical service, mechanical, waste management')
                ->setIsVisible(true);

            $navigation = new Navigation();

            $navigation
                ->setSlug($navigationSlug)
                ->setIsVisible(true)
                ->setTitle('Accuiel')
                ->setPosition(1) //add position check function
                ->setAbstractPage($homePage);

            $this->persistEntity($navigation);

            $homePage->setNavigation($navigation);

            $sectionSlug = 'accuiel-banner';
            $section = $this->sectionRepository->findBySlug($sectionSlug);

            if( is_null( $section ) ) {
                $section = new Section();

                $section
                    ->setTitle('Accuiel Banner')
                    ->setSlug($sectionSlug)
                    ->setDescription('Accuiel Banner Section')
                    ->setPosition(1) //add position check function
                    ->setIsVisible(true)
                    ->addAbstractPage($homePage);

                $chain = new Chain();

                $chain
                    ->setDescription('Accuiel Banner Row 1')
                    ->setPosition(1) //add position check function
                    ->setIsVisible(true);

                $column = new Column();

                $column
                    ->setDescription('Accuiel Banner Column 1')
                    ->setPosition(1) //add position check function
                    ->setIsVisible(true)
                    ->setChain($chain)
                ;

                $content1 = new Content();

                $content1
                    ->setDescription('Accuiel Banner Chain 1 Content 1')
                    ->setPosition(2) //add position check function
                    ->setIsVisible(true)
                    ->setContentKind($this->contentKindRepository->findByType('heading2'))
                    ->setResource('GÉNIE CIVIL')
                    ->setColumn($column)
                ;

                $content2 = new Content();

                $content2
                    ->setDescription('Accuiel Banner Chain 1 Content 2')
                    ->setPosition(1) //add position check function
                    ->setIsVisible(true)
                    ->setContentKind($this->contentKindRepository->findByType('span'))
                    ->setResource('Your best business support!')
                    ->setColumn($column)
                ;

                $this->persistEntity($content1);
                $this->persistEntity($content2);

                $column
                    ->addContent($content1)
                    ->addContent($content2)
                ;

                $this->persistEntity($column);

                $chain
                    ->addColumn($column);

                $this->persistEntity($chain);

                $section
                    ->addChain($chain);
            }

            $this->persistEntity($section);

            $homePage
                ->addSection($section);

            $this->persistEntity($homePage);

            $this->flush();
        }

        if ($this->isEntityManagerOpen()) {
            $this->commitTransaction();

            $this->eventDispatcher->dispatch
            (
                new Page()
            );
        }
        else {
            $this->rollBackTransaction();

            throw new \Exception('There was a problem importing default pages');
        }
    }

    /**
     * @return \App\Entity\Role
     * @throws MissingAttributeException
     * @throws UnknownPermissionTypeException
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\Exception
     * @throws \Exception
     */
    public function importRoles(): void
    {
        $permissions =
            [
                'Page Management' =>
                    [
                        'Super Admin' =>
                            [
                                Permission::PERMISSION_TYPE_CREATE,
                                Permission::PERMISSION_TYPE_DELETE,
                                Permission::PERMISSION_TYPE_EDIT,
                                Permission::PERMISSION_TYPE_VIEW,
                            ],
                        'Internal Admin' =>
                            [
                                Permission::PERMISSION_TYPE_CREATE,
                                Permission::PERMISSION_TYPE_DELETE,
                                Permission::PERMISSION_TYPE_EDIT,
                                Permission::PERMISSION_TYPE_VIEW,
                            ],
                        'Internal Editor' =>
                            [
                                Permission::PERMISSION_TYPE_EDIT,
                                Permission::PERMISSION_TYPE_VIEW,
                            ],
                        'Internal Viewer' =>
                            [
                                Permission::PERMISSION_TYPE_VIEW,
                            ]
                    ],
                'Settings - Company Profile' =>
                    [
                        'Super Admin' =>
                            [
                                Permission::PERMISSION_TYPE_CREATE,
                                Permission::PERMISSION_TYPE_DELETE,
                                Permission::PERMISSION_TYPE_EDIT,
                                Permission::PERMISSION_TYPE_VIEW,
                            ],
                        'Internal Admin' =>
                            [
                                Permission::PERMISSION_TYPE_CREATE,
                                Permission::PERMISSION_TYPE_EDIT,
                                Permission::PERMISSION_TYPE_VIEW,
                            ],
                    ],
                'External Users - Manage External Users' =>
                    [
                        'Super Admin' =>
                            [
                                Permission::PERMISSION_TYPE_CREATE,
                                Permission::PERMISSION_TYPE_DELETE,
                                Permission::PERMISSION_TYPE_EDIT,
                                Permission::PERMISSION_TYPE_VIEW,
                            ],
                        'Internal Admin' =>
                            [
                                Permission::PERMISSION_TYPE_CREATE,
                                Permission::PERMISSION_TYPE_EDIT,
                                Permission::PERMISSION_TYPE_VIEW,
                            ],
                        'Internal Editor' =>
                            [
                                Permission::PERMISSION_TYPE_EDIT,
                                Permission::PERMISSION_TYPE_VIEW,
                            ],
                        'Internal Viewer' =>
                            [
                                Permission::PERMISSION_TYPE_VIEW,
                            ],
                    ],
                'Users - Roles & Permissions' =>
                    [
                        'Super Admin' =>
                            [
                                Permission::PERMISSION_TYPE_CREATE,
                                Permission::PERMISSION_TYPE_DELETE,
                                Permission::PERMISSION_TYPE_EDIT,
                                Permission::PERMISSION_TYPE_VIEW,
                            ],
                    ],
            ];

        // format [ roleName => roleDescription ]
        $roles =
            [
                'Super Admin' => 'System Super User',
                'Internal Admin' => 'System Admin',
                'Internal Editor' => 'System Editor',
                'Internal Viewer' => 'System Viewer',
                'External User' => 'System External User',
            ];

        $this->beginTransaction();

        foreach ($roles as $role => $description) {
            $roleEntity = $this->roleDataTransferObject->toEntity(['name' => $role, 'description' => $description], new Role());

            if (is_null($this->roleRepository->findByName($role))) {
                $this->persistEntity($roleEntity);

                foreach ($permissions as $permissionName => $roleNames) {
                    foreach ($roleNames as $roleName => $permissionTypes) {
                        foreach ($permissionTypes as $permissionType) {
                            if ($roleName === $role) {
                                $permissionEntity = $this->permissionRepository->findByName
                                    (
                                        Permission::generatePermission
                                            (
                                                $permissionName,
                                                $permissionType
                                            )
                                    );

                                if ( is_null( $permissionEntity ) ) {
                                    $permissionEntity = $this->permissionDataTransferObject->toEntity
                                        (
                                            [
                                                'name' => $permissionName,
                                                'permissionType' => $permissionType
                                            ]
                                        );

                                    $this->persistEntity($permissionEntity);
                                }

                                $roleEntity->assignPermission($permissionEntity);
                            }
                        }
                    }
                }

                $this->entityManager->persist($roleEntity);
                $this->flush();
            }
        }

        if ($this->isEntityManagerOpen()) {
            $this->commitTransaction();

            $this->eventDispatcher->dispatch
            (
                new InternalUser()
            );
        }
        else {
            $this->rollBackTransaction();

            throw new \Exception('There was a problem importing roles and permissions');
        }
    }
}
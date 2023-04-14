<?php


namespace App\Service\Domain\Entity;


use App\Entity\Blog;
use App\Entity\Exception\UnknownPermissionTypeException;
use App\Entity\Page;
use App\Entity\Section;
use App\Service\Domain\Exception\MissingAttributeException;
use JetBrains\PhpStorm\Pure;

class SectionDataTransferObject extends DataTransferObject
{
    /**
     * @param Section $section
     * @return $this
     */
    public function fromEntity(Section $section): self
    {
        $sectionDTO = new static();

        $sectionDTO->id = $section->getId();
        $sectionDTO->uuid = $section->getUuid();
        $sectionDTO->description = $section->getDescription();
        $sectionDTO->position = $section->getPosition();
        $sectionDTO->style = $section->getStyle();
        $sectionDTO->isVisible = $section->isVisible();
        $sectionDTO->createdAt = $section->getCreatedAt();
        $sectionDTO->updatedAt = $section->getUpdatedAt();

        foreach ( $section->getAbstractPages() as $abstractPage ) {
            if ($abstractPage instanceof Page)
                $sectionDTO->pagesID[] = $abstractPage->getId();

            if ($abstractPage instanceof Blog)
                $sectionDTO->blogsID[] = $abstractPage->getId();
        }

        foreach ($section->getChains() as $chain)
            $sectionDTO->chains[] = (new ChainDataTransferObject())->fromEntity($chain);

        return $sectionDTO;
    }

//    /**
//     * @param array $data
//     * @param Permission|null $permission
//     * @return Permission
//     * @throws MissingAttributeException
//     * @throws UnknownPermissionTypeException
//     */
//    public function toEntity(array $data, Permission $permission = null): Permission
//    {
//        if
//            (
//                empty($data['name']) ||
//                empty($data['permissionType'])
//            )
//            throw new MissingAttributeException();
//
//        if (is_null($permission))
//            $permission = new Permission();
//
//        $permission
//            ->setName
//                (
//                    $data['name'],
//                    $data['permissionType']
//                );
//
//        if (isset($data['description']))
//            $permission->setDescription($data['description']);
//
//        return $permission;
//    }
}
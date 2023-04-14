<?php


namespace App\Service\Domain\Entity;


use App\Entity\Blog;
use App\Entity\Exception\UnknownPermissionTypeException;
use App\Entity\Page;
use App\Entity\Subnavigation;
use App\Service\Domain\Exception\MissingAttributeException;
use JetBrains\PhpStorm\Pure;

class SubnavigationDataTransferObject extends DataTransferObject
{
    /**
     * @param Subnavigation $subnavigation
     * @return $this
     */
    public function fromEntity(Subnavigation $subnavigation): self
    {
        $subnavigationDTO = new static();

        $subnavigationDTO->id = $subnavigation->getId();
        $subnavigationDTO->uuid = $subnavigation->getUuid();
        $subnavigationDTO->title = $subnavigation->getTitle();
        $subnavigationDTO->slug = $subnavigation->getSlug();
        $subnavigationDTO->position = $subnavigation->getPosition();
        $subnavigationDTO->style = $subnavigation->getStyle();
        $subnavigationDTO->isVisible = $subnavigation->isVisible();
        $subnavigationDTO->createdAt = $subnavigation->getCreatedAt();
        $subnavigationDTO->updatedAt = $subnavigation->getUpdatedAt();

        if ( $subnavigation->getAbstractPage() instanceof Page )
            $subnavigationDTO->pageID = $subnavigation->getAbstractPage()->getId();

        if ( $subnavigation->getAbstractPage() instanceof Blog )
            $subnavigationDTO->blogID = $subnavigation->getAbstractPage()->getId();

        if ( $subnavigation->getNavigation() )
            $subnavigationDTO->navigationID = $subnavigation->getNavigation()->getId();

        return $subnavigationDTO;
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
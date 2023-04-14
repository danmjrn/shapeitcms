<?php


namespace App\Service\Domain\Entity;


use App\Entity\Blog;
use App\Entity\Exception\UnknownPermissionTypeException;
use App\Entity\Navigation;
use App\Entity\Page;
use App\Service\Domain\Exception\MissingAttributeException;
use JetBrains\PhpStorm\Pure;

class NavigationDataTransferObject extends DataTransferObject
{
    /**
     * @param Navigation $navigation
     * @return $this
     */
    public function fromEntity(Navigation $navigation): self
    {
        $navigationDTO = new static();

        $navigationDTO->id = $navigation->getId();
        $navigationDTO->uuid = $navigation->getUuid();
        $navigationDTO->title = $navigation->getTitle();
        $navigationDTO->slug = $navigation->getSlug();
        $navigationDTO->position = $navigation->getPosition();
        $navigationDTO->style = $navigation->getStyle();
        $navigationDTO->isVisible = $navigation->isVisible();
        $navigationDTO->createdAt = $navigation->getCreatedAt();
        $navigationDTO->updatedAt = $navigation->getUpdatedAt();

        if ( $navigation->getAbstractPage() instanceof Page )
            $navigationDTO->pageID = $navigation->getAbstractPage()->getId();

        if ( $navigation->getAbstractPage() instanceof Blog )
            $navigationDTO->blogID = $navigation->getAbstractPage()->getId();


        foreach ($navigation->getSubnavigations() as $subnavigation)
            $navigationDTO->subnavigations[] = (new SubnavigationDataTransferObject())->fromEntity($subnavigation);

        return $navigationDTO;
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
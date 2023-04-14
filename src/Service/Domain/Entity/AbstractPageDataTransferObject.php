<?php


namespace App\Service\Domain\Entity;


use App\Entity\AbstractPage;
use App\Entity\Blog;
use App\Entity\Exception\UnknownPermissionTypeException;
use App\Entity\Page;
use App\Service\Domain\Exception\MissingAttributeException;
use JetBrains\PhpStorm\Pure;

class AbstractPageDataTransferObject extends DataTransferObject
{
    /**
     * @param AbstractPage|null $abstractPage
     * @return $this|null
     */
    public function fromEntity(AbstractPage $abstractPage = null): ?self
    {
        if (is_null($abstractPage))
            return null;

        $abstractPageDTO = new static();

        $abstractPageDTO->id = $abstractPage->getId();
        $abstractPageDTO->uuid = $abstractPage->getUuid();
        $abstractPageDTO->style = $abstractPage->getStyle();
        $abstractPageDTO->isVisible = $abstractPage->isVisible();
        $abstractPageDTO->createdAt = $abstractPage->getCreatedAt();
        $abstractPageDTO->updatedAt = $abstractPage->getUpdatedAt();

        if ( $abstractPage instanceof Page )
            $abstractPageDTO->type = AbstractPage::TYPE_PAGE;

        if ( $abstractPage instanceof Blog )
            $abstractPageDTO->type = AbstractPage::TYPE_BLOG;

        if ( $abstractPage->getNavigation() )
            $abstractPageDTO->navigation = (new NavigationDataTransferObject())->fromEntity($abstractPage->getNavigation());

        if ( $abstractPage->getSubnavigation() )
            $abstractPageDTO->subnavigation = (new SubnavigationDataTransferObject())->fromEntity($abstractPage->getSubnavigation());


        foreach ($abstractPage->getSections() as $section)
            $abstractPageDTO->sections[] = (new SectionDataTransferObject())->fromEntity($section);

        return $abstractPageDTO;
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
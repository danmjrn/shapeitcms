<?php


namespace App\Service\Domain\Entity;


use App\Entity\Content;
use App\Entity\Exception\UnknownPermissionTypeException;
use App\Entity\Permission;
use App\Service\Domain\Exception\MissingAttributeException;
use JetBrains\PhpStorm\Pure;

class ContentDataTransferObject extends DataTransferObject
{
    /**
     * @param Content $content
     * @return $this
     */
    public function fromEntity(Content $content): self
    {
        $contentDTO = new static();

        $contentDTO->id = $content->getId();
        $contentDTO->uuid = $content->getUuid();
        $contentDTO->description = $content->getDescription();
        $contentDTO->position = $content->getPosition();
        $contentDTO->resource = $content->getResource();
        $contentDTO->style = $content->getStyle();
        $contentDTO->isVisible = $content->isVisible();
        $contentDTO->createdAt = $content->getCreatedAt();
        $contentDTO->updatedAt = $content->getUpdatedAt();

        if($content->getColumn())
            $contentDTO->columnID = $content->getColumn()->getId();

        if($content->getContentKind()) {
            $contentDTO->contentKindID = $content->getContentKind()->getId();
            $contentDTO->contentKindType = $content->getContentKind()->getType();
        }

        return $contentDTO;
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
<?php


namespace App\Service\Domain\Entity;


use App\Entity\Column;
use App\Entity\Exception\UnknownPermissionTypeException;
use App\Service\Domain\Exception\MissingAttributeException;
use JetBrains\PhpStorm\Pure;

class ColumnDataTransferObject extends DataTransferObject
{
    /**
     * @param Column $column
     * @return $this
     */
    public function fromEntity(Column $column): self
    {
        $columnDTO = new static();

        $columnDTO->id = $column->getId();
        $columnDTO->uuid = $column->getUuid();
        $columnDTO->description = $column->getDescription();
        $columnDTO->position = $column->getPosition();
        $columnDTO->style = $column->getStyle();
        $columnDTO->isVisible = $column->isVisible();
        $columnDTO->createdAt = $column->getCreatedAt();
        $columnDTO->updatedAt = $column->getUpdatedAt();

        if($column->getChain())
            $columnDTO->chainID = $column->getChain()->getId();

        foreach ($column->getContent() as $content)
            $columnDTO->contents[] = (new ContentDataTransferObject())->fromEntity($content);

        return $columnDTO;
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
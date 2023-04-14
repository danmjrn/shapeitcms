<?php


namespace App\Service\Domain\Entity;


use App\Entity\Chain;
use App\Entity\Exception\UnknownPermissionTypeException;
use App\Service\Domain\Exception\MissingAttributeException;
use JetBrains\PhpStorm\Pure;

class ChainDataTransferObject extends DataTransferObject
{
    /**
     * @param Chain $chain
     * @return $this
     */
    public function fromEntity(Chain $chain): self
    {
        $chainDTO = new static();

        $chainDTO->id = $chain->getId();
        $chainDTO->uuid = $chain->getUuid();
        $chainDTO->description = $chain->getDescription();
        $chainDTO->position = $chain->getPosition();
        $chainDTO->style = $chain->getStyle();
        $chainDTO->isVisible = $chain->isVisible();
        $chainDTO->createdAt = $chain->getCreatedAt();
        $chainDTO->updatedAt = $chain->getUpdatedAt();

        if($chain->getSection())
            $chainDTO->sectionID = $chain->getSection()->getId();

        foreach ($chain->getColumns() as $column)
            $chainDTO->columns[] = (new ColumnDataTransferObject())->fromEntity($column);

        return $chainDTO;
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
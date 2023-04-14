<?php


namespace App\Service\Domain\Entity;


use App\Entity\ContentKind;

use App\Service\Domain\Exception\MissingAttributeException;

class ContentKindDataTransferObject extends DataTransferObject
{
    /**
     * @param ContentKind $contentKind
     * @return $this
     */
    public function fromEntity( ContentKind $contentKind ): self
    {
        $contentKindDTO = new static();

        $contentKindDTO->id = $contentKind->getId();
        $contentKindDTO->uuid = $contentKind->getUuid();
        $contentKindDTO->description = $contentKind->getDescription();
        $contentKindDTO->type = $contentKind->getType();

        return $contentKindDTO;
    }

    /**
     * @param array $data
     * @param ContentKind|null $contentKind
     * @return ContentKind
     * @throws MissingAttributeException
     */
    public function toEntity( array $data, ContentKind $contentKind = null ): ContentKind
    {
        if (
            empty( $data['type'] ) ||
            empty( $data['description'] )
        )
            throw new MissingAttributeException();

        if ( is_null( $contentKind ) )
            $contentKind = new ContentKind();

        $contentKind
            ->setType($data['type'])
            ->setDescription($data['description']);

        return $contentKind;
    }
}

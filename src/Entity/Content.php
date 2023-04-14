<?php

namespace App\Entity;

use App\Entity\Traits\LanguageTrait;
use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: ContentRepository::class)]
class Content
{
    use TimestampableEntity;

    use LanguageTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'uuid')]
    private ?string $uuid;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $position = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $resource = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isVisible = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $style = null;

    #[ORM\ManyToOne(targetEntity: Column::class, inversedBy: 'contents')]
    #[ORM\JoinColumn(name: 'column_id', referencedColumnName: 'id')]
    private ?Column $column = null;

    #[ORM\ManyToOne(targetEntity: ContentKind::class, inversedBy: 'contents')]
    #[ORM\JoinColumn(name: 'content_kind_id', referencedColumnName: 'id')]
    private ?ContentKind $contentKind = null;

    /**
     * @var Collection<Media>|null
     */
    #[ORM\ManyToMany(targetEntity: Media::class, mappedBy: 'contents')]
    private ?Collection $media;

    const LANGUAGE_EN = 'en';
    const LANGUAGE_FR = 'fr';

    public function __construct()
    {
        $this->media = new ArrayCollection();

        $this->uuid = Uuid::uuid4()->toString();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getResource(): ?string
    {
        return $this->resource;
    }

    public function setResource(string $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(?string $style): self
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @return Column|null
     */
    public function getColumn(): ?Column
    {
        return $this->column;
    }

    /**
     * @param Column|null $column
     * @return Content
     */
    public function setColumn(?Column $column): self
    {
        $this->column = $column;

        return $this;
    }

    /**
     * @return ContentKind|null
     */
    public function getContentKind(): ?ContentKind
    {
        return $this->contentKind;
    }

    /**
     * @param ContentKind|null $contentKind
     * @return Content
     */
    public function setContentKind(?ContentKind $contentKind): self
    {
        $this->contentKind = $contentKind;

        return $this;
    }

    /**
     * @return Collection<Media>|null
     */
    public function getMedia(): ?Collection
    {
        return $this->media;
    }

    /**
     * @param Media $media
     * @return $this
     */
    public function addMedia(Media $media): self
    {
        if (!$this->media->contains($media)) {
            $this->media[] = $media;
            $media->addContent($this);
        }

        return $this;
    }
}

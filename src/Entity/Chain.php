<?php

namespace App\Entity;

use App\Entity\Traits\LanguageTrait;
use App\Repository\ChainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: ChainRepository::class)]
class Chain
{
    use TimestampableEntity;

    use LanguageTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?string $uuid;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $style = null;

    #[ORM\Column]
    private ?bool $isVisible = false;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $position = null;

    #[ORM\ManyToOne(targetEntity: Section::class, inversedBy: 'chains')]
    #[ORM\JoinColumn(name: 'section_id', referencedColumnName: 'id', nullable: true)]
    private ?Section $section = null;

    /**
     * @var Collection<Column>|null
     */
    #[ORM\OneToMany(mappedBy: 'chain', targetEntity: Column::class)]
    private ?Collection $columns;

    /**
     * @var Collection<Media>|null
     */
    #[ORM\ManyToMany(targetEntity: Media::class, mappedBy: 'chains')]
    private ?Collection $media;

    public function __construct()
    {
        $this->columns = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function isVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

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

    /**
     * @return Section|null
     */
    public function getSection(): ?Section
    {
        return $this->section;
    }

    /**
     * @param Section|null $section
     */
    public function setSection(?Section $section): void
    {
        $this->section = $section;
    }

    /**
     * @return Collection
     */
    public function getColumns(): Collection
    {
        return $this->columns;
    }

    /**
     * @param Column $column
     * @return Chain
     */
    public function addColumn(Column $column): self
    {
        if (!$this->columns->contains($column)) {
            $this->columns[] = $column;
            $column->setChain($this);
        }

        return $this;
    }

    /**
     * @param Column $column
     * @return Chain
     */
    public function removeColumn(Column $column): self
    {
        if ($this->columns->removeElement($column)) {
            // set the owning side to null (unless already changed)
            if ($column->getChain() === $this) {
                $column->setChain(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getMedia(): ?Collection
    {
        return $this->media;
    }

    /**
     * @param Media $media
     * @return Chain
     */
    public function addMedia(Media $media): self
    {
        if (!$this->media->contains($media)) {
            $this->media[] = $media;
        }

        return $this;
    }
}

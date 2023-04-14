<?php

namespace App\Entity;

use App\Entity\Traits\LanguageTrait;
use App\Repository\ColumnRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: ColumnRepository::class)]
#[ORM\Table(name: '`column`')]
class Column
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

    #[ORM\Column]
    private ?bool $isVisible = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $style = null;

    #[ORM\ManyToOne(targetEntity: Chain::class, inversedBy: 'columns')]
    #[ORM\JoinColumn(name: 'chain_id', referencedColumnName: 'id')]
    private ?Chain $chain = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<Media>|null
     */
    #[ORM\ManyToMany(targetEntity: Media::class, mappedBy: 'columns')]
    private ?Collection $media;

    /**
     * @var Collection<Content>|null
     */
    #[ORM\OneToMany(mappedBy: 'column', targetEntity: Content::class)]
    private ?Collection $contents;

    public function __construct()
    {
        $this->contents = new ArrayCollection();
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
     * @return Chain|null
     */
    public function getChain(): ?Chain
    {
        return $this->chain;
    }

    /**
     * @param Chain|null $chain
     */
    public function setChain(?Chain $chain): void
    {
        $this->chain = $chain;
    }

    /**
     * @return Collection
     */
    public function getContent(): Collection
    {
        return $this->contents;
    }

    /**
     * @param Content $content
     * @return $this
     */
    public function addContent(Content $content): self
    {
        if ( ! $this->contents->contains($content) ) {
            $this->contents[] = $content;
            $content->setColumn($this);
        }

        return $this;
    }

    /**
     * @param Content $content
     * @return $this
     */
    public function removeContent(Content $content): self
    {
        if ( $this->contents->removeElement( $content ) ) {
            // set the owning side to null (unless already changed)
            if ( $content->getColumn() === $this ) {
                $content->setColumn(null);
            }
        }

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
        if ( ! $this->media->contains($media) ) {
            $this->media[] = $media;
            $media->addColumn($this);
        }

        return $this;
    }

}

<?php

namespace App\Entity;

use App\Repository\ContentKindRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: ContentKindRepository::class)]
class ContentKind
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'uuid')]
    private ?string $uuid;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<Content>|null
     */
    #[ORM\OneToMany(mappedBy: 'contentKind', targetEntity: Content::class)]
    private ?Collection $contents;

    public function __construct()
    {
        $this->contents = new ArrayCollection();

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
     * @return ArrayCollection|Collection|null
     */
    public function getContents(): ArrayCollection|Collection|null
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
            $content->setContentKind($this);
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
            if ( $content->getContentKind() === $this ) {
                $content->setContentKind(null);
            }
        }

        return $this;
    }
}

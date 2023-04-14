<?php

namespace App\Entity;

use App\Entity\Traits\LanguageTrait;
use App\Repository\NavigationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: NavigationRepository::class)]
class Navigation
{
    use TimestampableEntity;

    use LanguageTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $title = null;

    #[ORM\Column]
    private ?bool $isVisible = null;

    #[ORM\Column(type: 'uuid')]
    private ?string $uuid = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $style = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $position = null;

    #[ORM\OneToOne(mappedBy: 'navigation', targetEntity: AbstractPage::class)]
    private ?AbstractPage $abstractPage = null;

    /**
     * @var Collection<Subnavigation>|null
     */
    #[ORM\OneToMany(mappedBy: 'navigation', targetEntity: Subnavigation::class)]
    private ?Collection $subnavigations;

    /**
     * @var Collection<Media>|null
     */
    #[ORM\ManyToMany(targetEntity: Media::class, mappedBy: 'navigations')]
    private ?Collection $media;

    public function __construct()
    {
        $this->media = new ArrayCollection();
        $this->subnavigations = new ArrayCollection();

        $this->uuid = Uuid::uuid4()->toString();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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
     * @return Collection
     */
    public function getSubnavigations(): Collection
    {
        return $this->subnavigations;
    }

    public function addSubnavigation(Subnavigation $subnavigation): self
    {
        if (!$this->subnavigations->contains($subnavigation)) {
            $this->subnavigations[] = $subnavigation;
            $subnavigation->setNavigation($this);
        }

        return $this;
    }

    public function removeSubnavigation(Subnavigation $subnavigation): self
    {
        if ($this->subnavigations->contains($subnavigation)) {
            $this->subnavigations->removeElement($subnavigation);
            // set the owning side to null (unless already changed)
            if ($subnavigation->getNavigation() === $this) {
                $subnavigation->setNavigation(null);
            }
        }

        return $this;
    }

    /**
     * @return AbstractPage|null
     */
    public function getAbstractPage(): ?AbstractPage
    {
        return $this->abstractPage;
    }

    /**
     * @param AbstractPage|null $abstractPage
     */
    public function setAbstractPage(?AbstractPage $abstractPage): void
    {
        $this->abstractPage = $abstractPage;
    }

    /**
     * @param Media $media
     * @return $this
     */
    public function addMedia(Media $media): self
    {
        if (!$this->media->contains($media)) {
            $this->media[] = $media;
            $media->addNavigation($this);
        }

        return $this;
    }
}

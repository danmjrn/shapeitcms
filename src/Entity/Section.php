<?php

namespace App\Entity;

use App\Entity\Traits\LanguageTrait;
use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section
{
    use TimestampableEntity;

    use LanguageTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?string $uuid;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $style = null;

    #[ORM\Column]
    private ?bool $isVisible = false;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $position = null;

    /**
     * @var Collection<AbstractPage>|null
     */
    #[ORM\ManyToMany(targetEntity: AbstractPage::class, mappedBy: 'sections')]
    private ?Collection $abstractPages;

    /**
     * @var Collection<Media>|null
     */
    #[ORM\ManyToMany(targetEntity: Media::class, mappedBy: 'sections')]
    private ?Collection $media;

    /**
     * @var Collection<Chain>|null
     */
    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Chain::class)]
    private ?Collection $chains;

    public function __construct()
    {
        $this->abstractPages = new ArrayCollection();
        $this->chains = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
    public function getAbstractPages(): ArrayCollection|Collection|null
    {
        return $this->abstractPages;
    }

    public function addAbstractPage(AbstractPage $abstractPage): self
    {
        if (!$this->abstractPages->contains($abstractPage)) {
            $this->abstractPages[] = $abstractPage;
            $abstractPage->addSection($this);
        }

        return $this;
    }

    public function removeAbstractPage(AbstractPage $abstractPage): self
    {
        $this->abstractPages->removeElement($abstractPage);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getChains(): Collection
    {
        return $this->chains;
    }

    public function addChain(Chain $chain): self
    {
        if ( ! $this->chains->contains( $chain ) ) {
            $this->chains[] = $chain;
            $chain->setSection($this);
        }

        return $this;
    }

    public function removeChain(Chain $chain): self
    {
        if ( $this->chains->removeElement( $chain ) ) {
            // set the owning side to null (unless already changed)
            if ( $chain->getSection() === $this ) {
                $chain->setSection(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     * @return Section
     */
    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->isVisible;
    }

    /**
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int|null $position
     * @return Section
     */
    public function setPosition(?int $position): self
    {
        $this->position = $position;

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
     * @return Section
     */
    public function addMedia(Media $media): self
    {
        if ( ! $this->media->contains( $media ) ) {
            $this->media[] = $media;
            $media->addSection($this);
        }

        return $this;
    }

}

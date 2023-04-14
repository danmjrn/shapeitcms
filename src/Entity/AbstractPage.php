<?php

namespace App\Entity;

use App\Entity\Traits\LanguageTrait;
use App\Repository\AbstractPageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: AbstractPageRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'page' => Page::class,
    'blog' => Blog::class,
    'gallery' => Gallery::class,
    'about' => About::class,
    'contact' => Contact::class,
    'service' => Service::class
])]
abstract class AbstractPage
{
    use TimestampableEntity;

    use LanguageTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(type: 'uuid')]
    protected ?string $uuid = null;

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $style = null;

    #[ORM\Column]
    protected ?bool $isVisible = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $tags = null;

    #[ORM\OneToOne(inversedBy: 'abstractPage', targetEntity: Navigation::class)]
    protected ?Navigation $navigation = null;

    #[ORM\OneToOne(inversedBy: 'abstractPage', targetEntity: Subnavigation::class)]
    protected ?Subnavigation $subnavigation = null;

    /**
     * @var Collection<Section>|null
     */
    #[ORM\ManyToMany(targetEntity: Section::class, inversedBy: 'abstractPages')]
    #[ORM\JoinTable(name: 'abstract_page_section')]
    protected ?Collection $sections;

    /**
     * @var Collection<Media>|null
     */
    #[ORM\ManyToMany(targetEntity: Media::class, mappedBy: 'abstractPages')]
    protected ?Collection $media;

    const TYPE_PAGE = 'page';
    const TYPE_BLOG = 'blog';
    const TYPE_GALLERY = 'gallery';
    const TYPE_ABOUT = 'about';
    const TYPE_CONTACT = 'contact';
    const TYPE_SERVICE = 'service';

    public function __construct()
    {
        $this->sections = new ArrayCollection();
        $this->media = new ArrayCollection();

        $this->uuid = Uuid::uuid4()->toString();
    }

    /**
     * @param Section $section
     * @return $this
     */
    public function addSection(Section $section): self
    {
        if ( ! $this->sections->contains( $section ) ) {
            $this->sections[] = $section;
            $section->addAbstractPage( $this );
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Navigation|null
     */
    public function getNavigation(): ?Navigation
    {
        return $this->navigation;
    }

    /**
     * @return Collection
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    /**
     * @return string|null
     */
    public function getStyle(): ?string
    {
        return $this->style;
    }

    /**
     * @return Subnavigation|null
     */
    public function getSubnavigation(): ?Subnavigation
    {
        return $this->subnavigation;
    }

    /**
     * @return string|null
     */
    public function getTags(): ?string
    {
        return $this->tags;
    }

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @return bool|null
     */
    public function isVisible(): ?bool
    {
        return $this->isVisible;
    }

    /**
     * @param Section $section
     * @return $this
     */
    public function removeSection(Section $section): self
    {
        $this->sections->removeElement( $section );

        return $this;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param bool|null $isVisible
     * @return $this
     */
    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * @param Navigation|null $navigation
     * @return $this
     */
    public function setNavigation(?Navigation $navigation): self
    {
        $this->navigation = $navigation;

        return $this;
    }

    /**
     * @param string|null $style
     * @return $this
     */
    public function setStyle(?string $style): self
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @param Subnavigation|null $subnavigation
     * @return $this
     */
    public function setSubnavigation(?Subnavigation $subnavigation): self
    {
        $this->subnavigation = $subnavigation;

        return $this;
    }

    /**
     * @param string|null $tags
     * @return $this
     */
    public function setTags(?string $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @param string $uuid
     * @return $this
     */
    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

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
     * @return $this
     */
    public function addMedia(Media $media): self
    {
        if ( ! $this->media->contains( $media ) ) {
            $this->media[] = $media;
            $media->addAbstractPage( $this );
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return AbstractPage
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }


}

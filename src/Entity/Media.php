<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'uuid')]
    private ?string $uuid = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mediaType = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $fileName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $fileType = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $position = null;

    /**
     * @var Collection<Section>|null
     */
    #[ORM\ManyToMany(targetEntity: Section::class, inversedBy: 'media')]
    #[ORM\JoinTable(name: 'media_section')]
    private ?Collection $sections;

    /**
     * @var Collection<AbstractPage>|null
     */
    #[ORM\ManyToMany(targetEntity: AbstractPage::class, inversedBy: 'media')]
    #[ORM\JoinTable(name: 'media_abstract_page')]
    private ?Collection $abstractPages;

    /**
     * @var Collection<Navigation>|null
     */
    #[ORM\ManyToMany(targetEntity: Navigation::class, inversedBy: 'media')]
    #[ORM\JoinTable(name: 'media_navigation')]
    private ?Collection $navigations;

    /**
     * @var Collection<Subnavigation>|null
     */
    #[ORM\ManyToMany(targetEntity: Subnavigation::class, inversedBy: 'media')]
    #[ORM\JoinTable(name: 'media_subnavigation')]
    private ?Collection $subnavigations;

    /**
     * @var Collection<Chain>|null
     */
    #[ORM\ManyToMany(targetEntity: Chain::class, inversedBy: 'media')]
    #[ORM\JoinTable(name: 'media_chain')]
    private ?Collection $chains;

    /**
     * @var Collection<Column>|null
     */
    #[ORM\ManyToMany(targetEntity: Column::class, inversedBy: 'media')]
    #[ORM\JoinTable(name: 'media_column')]
    private ?Collection $columns;

    /**
     * @var Collection<Content>|null
     */
    #[ORM\ManyToMany(targetEntity: Content::class, inversedBy: 'media')]
    #[ORM\JoinTable(name: 'media_content')]
    private ?Collection $contents;

    /**
     * @var Collection<CompanyProfile>|null
     */
    #[ORM\ManyToMany(targetEntity: CompanyProfile::class, inversedBy: 'media')]
    #[ORM\JoinTable(name: 'media_company_profile')]
    private ?Collection $companyProfiles;

    /**
     * @var Collection<User>|null
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'media')]
    #[ORM\JoinTable(name: 'media_user')]
    private ?Collection $users;

    const MEDIA_TYPE_CONTENT = 'content';
    const MEDIA_TYPE_GALLERY = 'gallery';
    const MEDIA_TYPE_ICON = 'icon';
    const MEDIA_TYPE_LOGO = 'logo';
    const MEDIA_TYPE_PROFILE = 'profile';
    const MEDIA_TYPE_SLIDER = 'slider';

    const FILE_NAME_PLACEHOLDER = 'placeholder.png';

    const FILE_TYPE_AUDIO = 'audio';
    const FILE_TYPE_DOCUMENT = 'document';
    const FILE_TYPE_IMAGE = 'image';
    const FILE_TYPE_VIDEO = 'video';


    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->uuid = Uuid::uuid4()->toString();
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getMediaType(): ?string
    {
        return $this->mediaType;
    }

    public function setMediaType(string $mediaType): self
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getFileType(): ?string
    {
        return $this->fileType;
    }

    public function setFileType(?string $fileType): self
    {
        $this->fileType = $fileType;

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
     * @return Collection<Section>|null
     */
    public function getSections(): ?Collection
    {
        return $this->sections;
    }

    /**
     * @param Section $section
     * @return $this
     */
    public function addSection(Section $section): self
    {
        if (!$this->sections->contains($section)) {
            $this->sections[] = $section;
            $section->addMedia($this);
        }

        return $this;
    }

    /**
     * @return Collection<AbstractPage>|null
     */
    public function getAbstractPages(): ?Collection
    {
        return $this->abstractPages;
    }

    /**
     * @param AbstractPage $abstractPage
     * @return $this
     */
    public function addAbstractPage(AbstractPage $abstractPage): self
    {
        if (!$this->abstractPages->contains($abstractPage)) {
            $this->abstractPages[] = $abstractPage;
            $abstractPage->addMedia($this);
        }

        return $this;
    }

    /**
     * @return Collection<Navigation>|null
     */
    public function getNavigations(): ?Collection
    {
        return $this->navigations;
    }

    /**
     * @param Navigation $navigation
     * @return $this
     */
    public function addNavigation(Navigation $navigation): self
    {
        if (!$this->navigations->contains($navigation)) {
            $this->navigations[] = $navigation;
            $navigation->addMedia($this);
        }

        return $this;
    }

    /**
     * @return Collection<Subnavigation>|null
     */
    public function getSubnavigations(): ?Collection
    {
        return $this->subnavigations;
    }

    /**
     * @param Subnavigation $subnavigation
     * @return $this
     */
    public function addSubnavigation(Subnavigation $subnavigation): self
    {
        if (!$this->subnavigations->contains($subnavigation)) {
            $this->subnavigations[] = $subnavigation;
            $subnavigation->addMedia($this);
        }

        return $this;
    }

    /**
     * @return Collection<Chain>|null
     */
    public function getChains(): ?Collection
    {
        return $this->chains;
    }

    /**
     * @param Chain $chain
     * @return $this
     */
    public function addChain(Chain $chain): self
    {
        if (!$this->chains->contains($chain)) {
            $this->chains[] = $chain;
            $chain->addMedia($this);
        }

        return $this;
    }

    /**
     * @return Collection<Column>|null
     */
    public function getColumns(): ?Collection
    {
        return $this->columns;
    }

    /**
     * @param Column $column
     * @return $this
     */
    public function addColumn(Column $column): self
    {
        if (!$this->columns->contains($column)) {
            $this->columns[] = $column;
            $column->addMedia($this);
        }

        return $this;
    }

    /**
     * @return Collection<Content>|null
     */
    public function getContents(): ?Collection
    {
        return $this->contents;
    }

    /**
     * @param Content $content
     * @return $this
     */
    public function addContent(Content $content): self
    {
        if (!$this->contents->contains($content)) {
            $this->contents[] = $content;
            $content->addMedia($this);
        }

        return $this;
    }

    /**
     * @return Collection<CompanyProfile>|null
     */
    public function getCompanyProfiles(): ?Collection
    {
        return $this->companyProfiles;
    }

    /**
     * @param CompanyProfile $companyProfile
     * @return $this
     */
    public function addCompanyProfile(CompanyProfile $companyProfile): self
    {
        if (!$this->companyProfiles->contains($companyProfile)) {
            $this->companyProfiles[] = $companyProfile;
            $companyProfile->addMedia($this);
        }

        return $this;
    }

    /**
     * @return Collection<User>|null
     */
    public function getUsers(): ?Collection
    {
        return $this->users;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addMedia($this);
        }

        return $this;
    }
}

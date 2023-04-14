<?php

namespace App\Entity;

use App\Repository\CompanyProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: CompanyProfileRepository::class)]
class CompanyProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'uuid')]
    private ?string $uuid = null;

    #[ORM\Column(length: 255)]
    private ?string $companyName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyAddress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyContact = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $companyQueryEmail = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $companySalesEmail = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $companyDescription = null;

    /**
     * @var Collection<Media>|null
     */
    #[ORM\ManyToMany(targetEntity: Media::class, mappedBy: 'companyProfiles')]
    private ?Collection $media;

    public function __construct()
    {
        $this->media = new ArrayCollection();

        $this->uuid = Uuid::uuid4()->toString();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param string|null $uuid
     * @return $this
     */
    public function setUuid(?string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @param string|null $companyName
     * @return $this
     */
    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyAddress(): ?string
    {
        return $this->companyAddress;
    }

    /**
     * @param string|null $companyAddress
     * @return $this
     */
    public function setCompanyAddress(?string $companyAddress): self
    {
        $this->companyAddress = $companyAddress;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyContact(): ?string
    {
        return $this->companyContact;
    }

    /**
     * @param string|null $companyContact
     * @return $this
     */
    public function setCompanyContact(?string $companyContact): self
    {
        $this->companyContact = $companyContact;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyQueryEmail(): ?string
    {
        return $this->companyQueryEmail;
    }

    /**
     * @param string|null $companyQueryEmail
     * @return $this
     */
    public function setCompanyQueryEmail(?string $companyQueryEmail): self
    {
        $this->companyQueryEmail = $companyQueryEmail;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanySalesEmail(): ?string
    {
        return $this->companySalesEmail;
    }

    /**
     * @param string|null $companySalesEmail
     * @return $this
     */
    public function setCompanySalesEmail(?string $companySalesEmail): self
    {
        $this->companySalesEmail = $companySalesEmail;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyDescription(): ?string
    {
        return $this->companyDescription;
    }

    /**
     * @param string|null $companyDescription
     * @return $this
     */
    public function setCompanyDescription(?string $companyDescription): self
    {
        $this->companyDescription = $companyDescription;

        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getMedia(): Collection|null
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
            $media->addCompanyProfile($this);
        }

        return $this;
    }
}

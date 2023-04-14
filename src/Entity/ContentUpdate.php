<?php

namespace App\Entity;

use App\Repository\ContentUpdateRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: ContentUpdateRepository::class)]
class ContentUpdate
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'uuid')]
    private ?string $uuid = null;

    #[ORM\Column(type: 'uuid')]
    private ?string $currentNavigationUuid = null;

    #[ORM\Column(type: 'uuid')]
    private ?string $currentSubnavigationUuid = null;

    #[ORM\Column(type: 'uuid')]
    private ?string $currentAbstractPageUuid = null;

    #[ORM\Column(type: 'uuid')]
    private ?string $currentSectionUuid = null;

    #[ORM\Column(type: 'uuid')]
    private ?string $currentChainUuid = null;

    #[ORM\Column(type: 'uuid')]
    private ?string $currentColumnUuid = null;

    #[ORM\Column(type: 'uuid')]
    private ?string $currentContentUuid = null;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?string $previousNavigationUuid = null;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?string $previousSubnavigationUuid = null;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?string $previousAbstractPageUuid = null;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?string $previousSectionUuid = null;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?string $previousChainUuid = null;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?string $previousColumnUuid = null;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?string $previousContentUuid = null;

    public function __construct()
    {
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
     */
    public function setUuid(?string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string|null
     */
    public function getCurrentNavigationUuid(): ?string
    {
        return $this->currentNavigationUuid;
    }

    /**
     * @param string|null $currentNavigationUuid
     */
    public function setCurrentNavigationUuid(?string $currentNavigationUuid): void
    {
        $this->currentNavigationUuid = $currentNavigationUuid;
    }

    /**
     * @return string|null
     */
    public function getCurrentSubnavigationUuid(): ?string
    {
        return $this->currentSubnavigationUuid;
    }

    /**
     * @param string|null $currentSubnavigationUuid
     */
    public function setCurrentSubnavigationUuid(?string $currentSubnavigationUuid): void
    {
        $this->currentSubnavigationUuid = $currentSubnavigationUuid;
    }

    /**
     * @return string|null
     */
    public function getCurrentAbstractPageUuid(): ?string
    {
        return $this->currentAbstractPageUuid;
    }

    /**
     * @param string|null $currentAbstractPageUuid
     */
    public function setCurrentAbstractPageUuid(?string $currentAbstractPageUuid): void
    {
        $this->currentAbstractPageUuid = $currentAbstractPageUuid;
    }

    /**
     * @return string|null
     */
    public function getCurrentSectionUuid(): ?string
    {
        return $this->currentSectionUuid;
    }

    /**
     * @param string|null $currentSectionUuid
     */
    public function setCurrentSectionUuid(?string $currentSectionUuid): void
    {
        $this->currentSectionUuid = $currentSectionUuid;
    }

    /**
     * @return string|null
     */
    public function getCurrentChainUuid(): ?string
    {
        return $this->currentChainUuid;
    }

    /**
     * @param string|null $currentChainUuid
     */
    public function setCurrentChainUuid(?string $currentChainUuid): void
    {
        $this->currentChainUuid = $currentChainUuid;
    }

    /**
     * @return string|null
     */
    public function getCurrentColumnUuid(): ?string
    {
        return $this->currentColumnUuid;
    }

    /**
     * @param string|null $currentColumnUuid
     */
    public function setCurrentColumnUuid(?string $currentColumnUuid): void
    {
        $this->currentColumnUuid = $currentColumnUuid;
    }

    /**
     * @return string|null
     */
    public function getCurrentContentUuid(): ?string
    {
        return $this->currentContentUuid;
    }

    /**
     * @param string|null $currentContentUuid
     */
    public function setCurrentContentUuid(?string $currentContentUuid): void
    {
        $this->currentContentUuid = $currentContentUuid;
    }

    /**
     * @return string|null
     */
    public function getPreviousNavigationUuid(): ?string
    {
        return $this->previousNavigationUuid;
    }

    /**
     * @param string|null $previousNavigationUuid
     */
    public function setPreviousNavigationUuid(?string $previousNavigationUuid): void
    {
        $this->previousNavigationUuid = $previousNavigationUuid;
    }

    /**
     * @return string|null
     */
    public function getPreviousSubnavigationUuid(): ?string
    {
        return $this->previousSubnavigationUuid;
    }

    /**
     * @param string|null $previousSubnavigationUuid
     */
    public function setPreviousSubnavigationUuid(?string $previousSubnavigationUuid): void
    {
        $this->previousSubnavigationUuid = $previousSubnavigationUuid;
    }

    /**
     * @return string|null
     */
    public function getPreviousAbstractPageUuid(): ?string
    {
        return $this->previousAbstractPageUuid;
    }

    /**
     * @param string|null $previousAbstractPageUuid
     */
    public function setPreviousAbstractPageUuid(?string $previousAbstractPageUuid): void
    {
        $this->previousAbstractPageUuid = $previousAbstractPageUuid;
    }

    /**
     * @return string|null
     */
    public function getPreviousSectionUuid(): ?string
    {
        return $this->previousSectionUuid;
    }

    /**
     * @param string|null $previousSectionUuid
     */
    public function setPreviousSectionUuid(?string $previousSectionUuid): void
    {
        $this->previousSectionUuid = $previousSectionUuid;
    }

    /**
     * @return string|null
     */
    public function getPreviousChainUuid(): ?string
    {
        return $this->previousChainUuid;
    }

    /**
     * @param string|null $previousChainUuid
     */
    public function setPreviousChainUuid(?string $previousChainUuid): void
    {
        $this->previousChainUuid = $previousChainUuid;
    }

    /**
     * @return string|null
     */
    public function getPreviousColumnUuid(): ?string
    {
        return $this->previousColumnUuid;
    }

    /**
     * @param string|null $previousColumnUuid
     */
    public function setPreviousColumnUuid(?string $previousColumnUuid): void
    {
        $this->previousColumnUuid = $previousColumnUuid;
    }

    /**
     * @return string|null
     */
    public function getPreviousContentUuid(): ?string
    {
        return $this->previousContentUuid;
    }

    /**
     * @param string|null $previousContentUuid
     */
    public function setPreviousContentUuid(?string $previousContentUuid): void
    {
        $this->previousContentUuid = $previousContentUuid;
    }
}

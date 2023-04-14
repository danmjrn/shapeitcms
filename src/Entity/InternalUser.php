<?php

namespace App\Entity;

use App\Repository\InternalUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\AttributeOverride;

#[ORM\Entity(repositoryClass: InternalUserRepository::class)]
class InternalUser extends User
{
    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, unique: true, nullable: true)]
    protected ?string $email = null;

    #[ORM\OneToOne(inversedBy: 'internalUser', targetEntity: InternalActivity::class)]
    private ?InternalActivity $internalActivity = null;

    public function __construct()
    {
        $this->isDeleted = false;
        $this->isVerified = false;

        parent::__construct();
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return InternalActivity|null
     */
    public function getInternalActivity(): ?InternalActivity
    {
        return $this->internalActivity;
    }

    /**
     * @param InternalActivity|null $internalActivity
     */
    public function setInternalActivity(?InternalActivity $internalActivity): void
    {
        $this->internalActivity = $internalActivity;
    }
}

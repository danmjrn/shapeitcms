<?php

namespace App\Entity;

use App\Repository\ExternalUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExternalUserRepository::class)]
class ExternalUser extends User
{
    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, unique: true, nullable: true)]
    protected ?string $email = null;

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
}

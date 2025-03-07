<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service extends AbstractPage
{

    public function __construct()
    {
        $this->isVisible = false;

        parent::__construct();
    }
}

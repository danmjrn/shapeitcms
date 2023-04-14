<?php

namespace App\Entity;

use App\Repository\AboutRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AboutRepository::class)]
class About extends AbstractPage
{

    public function __construct()
    {
        $this->isVisible = false;

        parent::__construct();
    }
}

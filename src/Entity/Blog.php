<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlogRepository::class)]
class Blog extends AbstractPage
{
    public function __construct()
    {
        $this->isVisible = false;

        parent::__construct();
    }
}

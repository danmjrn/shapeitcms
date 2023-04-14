<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page extends AbstractPage
{
    public function __construct()
    {
        $this->isVisible = false;

        parent::__construct();
    }
}

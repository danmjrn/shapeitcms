<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact extends AbstractPage
{

    public function __construct()
    {
        $this->isVisible = false;

        parent::__construct();
    }
}

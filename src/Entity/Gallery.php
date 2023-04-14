<?php

namespace App\Entity;

use App\Repository\GalleryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GalleryRepository::class)]
class Gallery extends AbstractPage
{

    public function __construct()
    {
        $this->isVisible = false;

        parent::__construct();
    }
}

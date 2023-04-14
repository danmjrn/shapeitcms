<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait LanguageTrait
{
    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    protected string $languageCode;

    /**
     * @return string
     */
    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }

    /**
     * @param string $languageCode
     * @return $this|null
     */
    public function setLanguageCode(string $languageCode): ?self
    {
        $this->languageCode = $languageCode;

        return $this;
    }
}
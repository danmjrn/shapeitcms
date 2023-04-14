<?php


namespace App\Service\Domain;


use App\Entity\AbstractPage;
use App\Repository\AbstractPageRepository;
use App\Service\Domain\Entity\AbstractPageDataTransferObject;

class AbstractPageService
{
    /**
     * @var AbstractPageDataTransferObject
     */
    private AbstractPageDataTransferObject $abstractPageDataTransferObject;

    /**
     * @var AbstractPageRepository
     */
    private AbstractPageRepository $abstractPageRepository;

    /**
     * @param AbstractPageRepository $abstractPageRepository
     */
    public function __construct
        (
            AbstractPageDataTransferObject $abstractPageDataTransferObject,
            AbstractPageRepository $abstractPageRepository
        )
    {
        $this->abstractPageDataTransferObject = $abstractPageDataTransferObject;
        $this->abstractPageRepository = $abstractPageRepository;
    }

    /**
     * @param string $navigationSlug
     * @param bool $convertToDto
     * @return AbstractPageDataTransferObject|AbstractPage|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getAbstractPageByNavigationSlug(string $navigationSlug, bool $convertToDto = true): AbstractPageDataTransferObject|AbstractPage|null
    {
        $abstractPage = $this->abstractPageRepository->findAbstractPageByNavigationSlug($navigationSlug);

        return $convertToDto ? $this->abstractPageDataTransferObject->fromEntity($abstractPage) : $abstractPage;
    }


}

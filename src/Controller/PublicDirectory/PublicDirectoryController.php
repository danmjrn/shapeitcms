<?php

namespace App\Controller\PublicDirectory;

use App\Repository\AbstractPageRepository;
use App\Repository\NavigationRepository;
use App\Repository\SubnavigationRepository;
use App\Service\Domain\AbstractPageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicDirectoryController extends AbstractController
{
    /**
     * @var AbstractPageRepository
     */
    private AbstractPageService $abstractService;

    /**
     * @var NavigationRepository
     */
    private NavigationRepository $navigationRepository;

    /**
     * @var SubnavigationRepository
     */
    private SubnavigationRepository $subnavigationRepository;

    public function __construct
        (
            AbstractPageService $abstractPageService,
            NavigationRepository $navigationRepository,
            SubnavigationRepository $subnavigationRepository
        )
    {
        $this->abstractPageService = $abstractPageService;
        $this->navigationRepository = $navigationRepository;
        $this->subnavigationRepository = $subnavigationRepository;
    }


    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    #[Route('/', name: 'public_directory')]
    public function home(): Response
    {
        $page = $this->abstractPageService->getAbstractPageByNavigationSlug('accuiel');

        if (! is_null($page)) {
            return $this->render('public_directory/page/show.html.twig', [
                'page' => $page,
            ]);
        }

        return $this->render('public_directory/default.html.twig', [
            'eventDate' => '01 April 2023 12:30:00',
        ]);
    }
}

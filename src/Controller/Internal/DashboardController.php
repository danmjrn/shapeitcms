<?php

namespace App\Controller\Internal;

use App\Entity\InternalUser;
use App\Security\AccessControl\Traits\AccessControlTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route( '/internal' )]
class DashboardController extends AbstractController
{
    use AccessControlTrait;

//    /**
//     * @var InvitationService
//     */
//    private InvitationService $invitationService;
//
//    /**
//     * @var InviteeService
//     */
//    private InviteeService $inviteeService;

    public function __construct
        (
//            InvitationService $invitationService,
//            InviteeService $inviteeService,
        )
    {
//        $this->invitationService = $invitationService;
//        $this->inviteeService = $inviteeService;
    }

    /**
     * @return Response
     */
    #[Route( path: '/', name: 'internal_dashboard' )]
    public function home(): Response
    {
        return $this->render('internal/dashboard.html.twig', [
            'dash' => 'Dash',
        ]);
    }
}

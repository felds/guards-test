<?php
declare(strict_types=1);

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/connect") */
class ConnectController extends Controller
{
    /** @Route("/") */
    public function indexAction(ClientRegistry $registry)
    {
        return $registry
            ->getClient('google')
            ->redirect();
    }

    /** @Route("/check") */
    public function checkAction()
    {
        throw $this->createAccessDeniedException("You shouldn't be here.");
    }
}

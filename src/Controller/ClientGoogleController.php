<?php

namespace App\Controller;

use Google\Service\AdExchangeBuyerII\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/equipement{id}')]
class ClientGoogleController extends AbstractController
{
    #[Route('/', name: 'app_client_google')]
    public function index(): Response
    {   

        return $this->render('client_google/index.html.twig', [
            'controller_name' => 'ClientGoogleController',
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\EquipementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('admin', name: 'app_admin_index', methods: ['GET'])]
    public function index(EquipementsRepository $equipementsRepository, UserRepository $userRepository): Response
    {
        
        return $this->render('admin/index.html.twig', [
            'equipements' => $equipementsRepository->findAll(),
            'users' => $userRepository->findAll(),
        ]);
    }
}
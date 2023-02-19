<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\EquipementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EquipementsRepository $equipementsRepository, CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'equipements' => $equipementsRepository->findBy([],
            ['id' => 'asc']),
            'categories' => $categoriesRepository->findBy([],
            ['id' => 'asc'])
        ]);
    }
}

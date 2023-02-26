<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\EquipementsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Equipements;
use App\Form\AddModalFormType;
use App\Form\EditModalFormType;
use App\Form\SearchEquipementsType;

class HomeController extends AbstractController
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/home', name: 'app_home')]
    public function index(EquipementsRepository $equipementsRepository, CategoriesRepository $categoriesRepository, Request $request): Response
    {

        $notificationSearch = null;
        $equipementsDsiplay = $equipementsRepository->findBy([],['id' => 'asc']);
        $searchForm = $this->createForm(SearchEquipementsType::class);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            //searchEquipements corresponding to the words searched
            $equipementsDsiplay = $equipementsRepository->findEquipementsByName($searchForm->get('word')->getData());
            $notificationSearch = 'Recheche effectuée !';
        }

        //Add equipement form
        $equipement = new Equipements();
        $formAddEquipement = $this->createForm(AddModalFormType::class, $equipement);
        $formAddEquipement->handleRequest($request);

        //edit equipement form
        $formEditEquipement = $this->createForm(EditModalFormType::class);
        $formEditEquipement->handleRequest($request);
        
        // if validated and submitted ->add or edit form
        if ($formAddEquipement->isSubmitted() && $formAddEquipement->isValid() ||$formEditEquipement->isSubmitted() && $formEditEquipement->isValid() ) {

            $equipement = $formAddEquipement->getData();
            $this->entityManager->persist($equipement);
            $this->entityManager->flush(); 
            
            $notification = 'Equipement ajouté !';

            return $this->redirectToRoute('app_home'); 

        } else {
            
            $notification = 'Équipement pas ajouté, veuillez vérifier les champs saisies'; 
        }
    
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
             //notifications
             'notificationsSearch' => $notificationSearch,
             'notifications' => $notification,
            //forms create views
            'addForm' => $formAddEquipement->createView(),
            'editForm' => $formEditEquipement->createView(),
            'form' => $searchForm->createView(),

            //call repositories to find them by id and display each equipement by card -> uses on home/index.html.twig
            'equipements' => $equipementsDsiplay,
            'categories' => $categoriesRepository->findBy([],
            ['id' => 'asc']),
        ]);
    }

    
    // public function new(EquipementsRepository $equipementsRepository, CategoriesRepository $categoriesRepository, Request $request): Response
    // {
    //     $notification = null;
    //     // Add new equipement using form ModalFormType
    //     $equipement = new Equipements();
    //     $formAddEquipement = $this->createForm(AddModalFormType::class, $equipement);
    //     $formAddEquipement->handleRequest($request);

    //     if ($formAddEquipement->isSubmitted() && $formAddEquipement->isValid()) {
            
    //         $equipement = $formAddEquipement->getData();
    //         $this->entityManager->persist($equipement);
    //         $this->entityManager->flush(); 
            
    //         $notification = 'Equipement ajouté !';

    //         return $this->redirectToRoute('app_home'); 

    //     } else {
            
    //         $notification = 'L\'équipement n\'a pas pu être ajouté, veuillez vérifier les champs saisies'; 
    //     }

    //     return $this->render('home/index.html.twig', [
    //         //createView for addForm
    //         'addForm' => $formAddEquipement->createView(),
    //         //insert notifications TODO
    //         'notification' => $notification,
    //         'equipements' => $equipementsRepository->findBy([],
    //         ['id' => 'asc']),
    //         'categories' => $categoriesRepository->findBy([],
    //         ['id' => 'asc']),
    //         'controller_name' => 'HomeController::new',
    //     ]);
    // }

    // public function edit(EquipementsRepository $equipementsRepository, CategoriesRepository $categoriesRepository, Request $request): Response
    // {
    //     $notification = null;

    //     $formEditEquipement = $this->createForm(EditModalFormType::class);
    //     $formEditEquipement->handleRequest($request);
        

    //     if ($formEditEquipement->isSubmitted() && $formEditEquipement->isValid()) {
    //        echo $formEditEquipement->getName();
    //     }
       

    //     return $this->render('home/index.html.twig', [
    //         //createView for addForm
    //         'editForm' => $formEditEquipement->createView(),
    //         //insert notifications TODO
    //         'notification' => $notification,
    //         'equipements' => $equipementsRepository->findBy([],
    //         ['id' => 'asc']),
    //         'categories' => $categoriesRepository->findBy([],
    //         ['id' => 'asc']),
    //     ]);
    // }
}

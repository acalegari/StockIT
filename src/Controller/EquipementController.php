<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Equipements;
use App\Entity\Reservations;
use App\Form\ReservationFormType;

class EquipementController extends AbstractController
{
    // #[Route('/equipement', name: 'app_equipement')]
    // public function index(): Response
    // {

    //     return $this->render('equipement/show.html.twig', [
    //          'controller_name' => 'EquipementController',
    //     ]);
    // }

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/equipement/{id}', name: 'app_equipement')]
    public function index(ManagerRegistry $doctrine, int $id, Request $request): Response
    {
        //display all equipements created on database
        $equipement = $doctrine->getRepository(Equipements::class)->find($id);

        if (!$equipement) {
            throw $this->createNotFoundException(
                'Aucun équipement trouvé pour l\id : '.$id
            );
        }

        $reservation = new Reservations();
        $form = $this->createForm(ReservationFormType::class, $reservation);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($reservation);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_equipement'); // retrieve equipement.id
        }
        
        return $this->render('equipement/show.html.twig', [
            'equipement' => $equipement,
            'reservation' => $reservation,
            'form' => $form->createView(),

        ]);     
    }
}

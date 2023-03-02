<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Equipements;

class EquipementController extends AbstractController
{
    // #[Route('/equipement', name: 'app_equipement')]
    // public function index(): Response
    // {

    //     return $this->render('equipement/show.html.twig', [
    //          'controller_name' => 'EquipementController',
    //     ]);
    // }

    #[Route('/equipement/{id}', name: 'app_equipement')]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        //display all equipements created on database
        $equipement = $doctrine->getRepository(Equipements::class)->find($id);

        if (!$equipement) {
            throw $this->createNotFoundException(
                'Aucun équipement trouvé pour l\id : '.$id
            );
        }

        
        return $this->render('equipement/show.html.twig', ['equipement' => $equipement]);     
    }
}

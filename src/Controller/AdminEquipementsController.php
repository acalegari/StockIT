<?php

namespace App\Controller;

use App\Entity\Equipements;
use App\Form\EquipementsType;
use App\Repository\EquipementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/equipements')]
class AdminEquipementsController extends AbstractController
{
    #[Route('/', name: 'app_admin_equipements_index', methods: ['GET'])]
    public function index(EquipementsRepository $equipementsRepository): Response
    {
        return $this->render('admin/equipements/index.html.twig', [
            'equipements' => $equipementsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_equipements_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EquipementsRepository $equipementsRepository): Response
    {
        $equipement = new Equipements();
        $form = $this->createForm(EquipementsType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipement = $form->getData();
            
            $equipementsRepository->save($equipement, true);

            return $this->redirectToRoute('app_admin_equipements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/equipements/new.html.twig', [
            'equipement' => $equipement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_equipements_show', methods: ['GET'])]
    public function show(Equipements $equipements): Response
    {
        return $this->render('admin/equipements/show.html.twig', [
            'equipement' => $equipements,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_equipements_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Equipements $equipement, EquipementsRepository $equipementsRepository): Response
    {
        $form = $this->createForm(EquipementsType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipementsRepository->save($equipement, true);

            return $this->redirectToRoute('app_admin_equipements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/equipements/edit.html.twig', [
            'equipement' => $equipement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_equipements_delete', methods: ['POST'])]
    public function delete(Request $request, Equipements $equipement, EquipementsRepository $equipementsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipement->getId(), $request->request->get('_token'))) {
            $equipementsRepository->remove($equipement, true);
        }
        return $this->redirectToRoute('app_admin_equipements_index', [], Response::HTTP_SEE_OTHER);
    }
}

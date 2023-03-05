<?php

namespace App\Controller;

use App\Entity\Equipements;
use App\Form\EquipementsType;
use App\Repository\EquipementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\imageUploadService;
use DateTimeImmutable;

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
    public function new(Request $request, EquipementsRepository $equipementsRepository, imageUploadService $imageUpload): Response
    {
        $notification = null;
        $equipement = new Equipements();
        $form = $this->createForm(EquipementsType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        //retieve image
            $image = $form->get('imagePath')->getData();

        //call service to add image
            $equipement = $form->getData();
        /*call imageUploadService to add the new reformated (webp) images (original + resized) into img\data folder
            /!\ add function return an array 0-> originalName 1-> resizeName */
            $file = $imageUpload->add($image);
            $equipement->setImage($file[0]);
            $equipement->setImagePath($file[1]);

            //insert new date automatically
            $date = new DateTimeImmutable();
            $equipement->setCreatedAt($date);
            
            $equipementsRepository->save($equipement, true);
            
            $notification = 'Equipement ajouté !';

            return $this->redirectToRoute('app_admin_equipements_index', [], Response::HTTP_SEE_OTHER);

        } else {
            
            $notification = 'Équipement pas ajouté, veuillez vérifier les champs saisies'; 
        }

        return $this->renderForm('admin/equipements/new.html.twig', [
            'equipement' => $equipement,
            'form' => $form,
            'notification' => $notification,
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
    public function edit(Request $request, Equipements $equipement, EquipementsRepository $equipementsRepository, imageUploadService $imageUpload): Response
    {
        $notification = null;
        $form = $this->createForm(EquipementsType::class, $equipement);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
           
            $imageBefore = $equipement->getImage();

            //retieve original image name
            $image = $form->get('imagePath')->getData();
            $equipement = $form->getData();

            //Check if the submitted form contains image
            if(!empty($image) == true) {
                //if equipement edited already contains an image attached; call imageUploadService to remove it
                if (!empty($imageBefore)) {
                    $imageUpload->delete($imageBefore);
                }

                /*call imageUploadService to add the new reformated (webp) images (original + resized) into img\data folder
                    /!\ add function return an array 0-> original name 1-> resize name */
                $file = $imageUpload->add($image); 
                $equipement->setImage($file[0]);
                $equipement->setImagePath($file[1]);

            } else {
                //add error, equipement needs to have an image ??
            }
            
            //update data's equipement
            $equipementsRepository->save($equipement, true);
            $notification = 'Equipement ajouté !';

            return $this->redirectToRoute('app_admin_equipements_index', [], Response::HTTP_SEE_OTHER);

        } else {
            
            $notification = 'Équipement pas ajouté, veuillez vérifier les champs saisies'; 
        }

        return $this->renderForm('admin/equipements/edit.html.twig', [
            'equipement' => $equipement,
            'form' => $form,
            'notification' => $notification,
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

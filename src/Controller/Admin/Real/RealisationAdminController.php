<?php

namespace App\Controller\Admin\Real;

use App\Entity\Realisation;
use App\Form\Admin\Real\RealisationType;
use App\Repository\RealisationRepository;
use App\Service\UploadReal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/zone-admin/realisation-admin")
 * @IsGranted("ROLE_ADMIN")
 */
class RealisationAdminController extends AbstractController
{
    /**
     * @Route("/", name="realisation_admin_index", methods={"GET"})
     */
    public function index(RealisationRepository $realisationRepository): Response
    {
        return $this->render('admin/real/realisation_admin/index.html.twig', [
            'realisations' => $realisationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="realisation_admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, UploadReal $uploadReal): Response
    {
        $realisation = new Realisation();
        $form = $this->createForm(RealisationType::class, $realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form->get('picture')->getData()) {
                $fileName = $uploadReal->upload($image);
                //Mets a jour l'entite
                $realisation->setPicture($fileName);
            }
            $entityManager->persist($realisation);
            $entityManager->flush();

            return $this->redirectToRoute('realisation_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/real/realisation_admin/new.html.twig', [
            'realisation' => $realisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="realisation_admin_show", methods={"GET"})
     */
    public
    function show(Realisation $realisation): Response
    {
        return $this->render('admin/real/realisation_admin/show.html.twig', [
            'realisation' => $realisation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="realisation_admin_edit", methods={"GET", "POST"})
     */
    public
    function edit(Request $request, Realisation $realisation, UploadReal $uploadReal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RealisationType::class, $realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form->get('picture')->getData()) {
                // Supprimer l'image deja existante
                if ($realisation->getPicture()) {
                    $uploadReal->remove($realisation->getPicture());
                }
                $fileName = $uploadReal->upload($image);
                //Mets a jour l'entite
                $realisation->setPicture($fileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('realisation_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/real/realisation_admin/edit.html.twig', [
            'realisation' => $realisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="realisation_admin_delete", methods={"POST"})
     */
    public
    function delete(Request $request, Realisation $realisation, UploadReal $uploadReal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $realisation->getId(), $request->request->get('_token'))) {
            if ($realisation->getPicture()) {
                $uploadReal->remove($realisation->getPicture());
            }
            $entityManager->remove($realisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('realisation_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}

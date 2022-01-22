<?php

namespace App\Controller\Admin\Real;

use App\Entity\Realisation;
use App\Form\RealisationType;
use App\Repository\RealisationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/realisation/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class RealisationAdminController extends AbstractController
{
    /**
     * @Route("/", name="realisation_admin_index", methods={"GET"})
     */
    public function index(RealisationRepository $realisationRepository): Response
    {
        return $this->render('admin/Real/realisation_admin/index.html.twig', [
            'realisations' => $realisationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="realisation_admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $realisation = new Realisation();
        $form = $this->createForm(RealisationType::class, $realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($realisation);
            $entityManager->flush();

            return $this->redirectToRoute('realisation_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/Real/realisation_admin/new.html.twig', [
            'realisation' => $realisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="realisation_admin_show", methods={"GET"})
     */
    public function show(Realisation $realisation): Response
    {
        return $this->render('admin/Real/realisation_admin/show.html.twig', [
            'realisation' => $realisation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="realisation_admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Realisation $realisation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RealisationType::class, $realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('realisation_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/Real/realisation_admin/edit.html.twig', [
            'realisation' => $realisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="realisation_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, Realisation $realisation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$realisation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($realisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('realisation_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}

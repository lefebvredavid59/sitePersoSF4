<?php

namespace App\Controller\Admin\Collection;

use App\Entity\CollectionEdition;
use App\Form\Admin\CollectionEditionType;
use App\Repository\CollectionEditionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/collection-edition-admin")
 */
class CollectionEditionAdminController extends AbstractController
{
    /**
     * @Route("/", name="collection_edition_admin_index", methods={"GET"})
     */
    public function index(CollectionEditionRepository $collectionEditionRepository): Response
    {
        return $this->render('admin/collection/collection_edition_admin/index.html.twig', [
            'collection_editions' => $collectionEditionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="collection_edition_admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $collectionEdition = new CollectionEdition();
        $form = $this->createForm(CollectionEditionType::class, $collectionEdition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($collectionEdition);
            $entityManager->flush();

            return $this->redirectToRoute('collection_edition_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/collection/collection_edition_admin/new.html.twig', [
            'collection_edition' => $collectionEdition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collection_edition_admin_show", methods={"GET"})
     */
    public function show(CollectionEdition $collectionEdition): Response
    {
        return $this->render('admin/collection/collection_edition_admin/show.html.twig', [
            'collection_edition' => $collectionEdition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="collection_edition_admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CollectionEdition $collectionEdition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CollectionEditionType::class, $collectionEdition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('collection_edition_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/collection/collection_edition_admin/edit.html.twig', [
            'collection_edition' => $collectionEdition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collection_edition_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, CollectionEdition $collectionEdition, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collectionEdition->getId(), $request->request->get('_token'))) {
            $entityManager->remove($collectionEdition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('collection_edition_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}

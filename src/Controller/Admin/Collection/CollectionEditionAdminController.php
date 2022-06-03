<?php

namespace App\Controller\Admin\Collection;

use App\Entity\CollectionEdition;
use App\Form\Admin\Collection\CollectionEditionType;
use App\Repository\CollectionEditionRepository;
use App\Service\UploadCollectionEdition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/zone-admin/collection-edition-admin")
 * @IsGranted("ROLE_ADMIN")
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
    public function new(Request $request, EntityManagerInterface $entityManager,
                        UploadCollectionEdition $upload): Response
    {
        $collectionEdition = new CollectionEdition();
        $form = $this->createForm(CollectionEditionType::class, $collectionEdition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form->get('picture')->getData()) {
                $fileName = $upload->upload($image);
                //Mets a jour l'entite
                $collectionEdition->setPicture($fileName);
            }
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
    public function edit(Request $request, CollectionEdition $collectionEdition, EntityManagerInterface $entityManager,
                         UploadCollectionEdition $upload): Response
    {
        $form = $this->createForm(CollectionEditionType::class, $collectionEdition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form->get('picture')->getData()) {
                // Supprimer l'image deja existante
                if ($collectionEdition->getPicture()) {
                    $upload->remove($collectionEdition->getPicture());
                }
                $fileName = $upload->upload($image);
                //Mets a jour l'entite
                $collectionEdition->setPicture($fileName);
            }
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
    public function delete(Request $request, CollectionEdition $collectionEdition, EntityManagerInterface $entityManager, UploadCollectionEdition $uploadCollectionEdition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collectionEdition->getId(), $request->request->get('_token'))) {
            if ($collectionEdition->getPicture()) {
                $uploadCollectionEdition->remove($collectionEdition->getPicture());
            }
            $entityManager->remove($collectionEdition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('collection_edition_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}

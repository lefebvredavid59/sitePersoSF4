<?php

namespace App\Controller\Admin\Collection;

use App\Entity\CollectionCategory;
use App\Form\Admin\Collection\CollectionCategoryType;
use App\Repository\CollectionCategoryRepository;
use App\Service\UploadCollectionCategory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/collection-category-admin")
 * @IsGranted("ROLE_ADMIN")
 */
class CollectionCategoryAdminController extends AbstractController
{
    /**
     * @Route("/", name="collection_category_admin_index", methods={"GET"})
     */
    public function index(CollectionCategoryRepository $collectionCategoryRepository): Response
    {
        return $this->render('admin/collection/collection_category_admin/index.html.twig', [
            'collection_categories' => $collectionCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="collection_category_admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, UploadCollectionCategory $uploadCollectionCategory): Response
    {
        $collectionCategory = new CollectionCategory();
        $form = $this->createForm(CollectionCategoryType::class, $collectionCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form->get('picture')->getData()) {
                $fileName = $uploadCollectionCategory->upload($image);
                //Mets a jour l'entite
                $collectionCategory->setPicture($fileName);
            }
            $entityManager->persist($collectionCategory);
            $entityManager->flush();

            return $this->redirectToRoute('collection_category_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/collection/collection_category_admin/new.html.twig', [
            'collection_category' => $collectionCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collection_category_admin_show", methods={"GET"})
     */
    public function show(CollectionCategory $collectionCategory): Response
    {
        return $this->render('admin/collection/collection_category_admin/show.html.twig', [
            'collection_category' => $collectionCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="collection_category_admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CollectionCategory $collectionCategory,
                         EntityManagerInterface $entityManager, UploadCollectionCategory $uploadCollectionCategory): Response
    {
        $form = $this->createForm(CollectionCategoryType::class, $collectionCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form->get('picture')->getData()) {
                // Supprimer l'image deja existante
                if ($collectionCategory->getPicture()) {
                    $uploadCollectionCategory->remove($collectionCategory->getPicture());
                }
                $fileName = $uploadCollectionCategory->upload($image);
                //Mets a jour l'entite
                $collectionCategory->setPicture($fileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('collection_category_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/collection/collection_category_admin/edit.html.twig', [
            'collection_category' => $collectionCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collection_category_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, CollectionCategory $collectionCategory,
                           EntityManagerInterface $entityManager, UploadCollectionCategory $uploadCollectionCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collectionCategory->getId(), $request->request->get('_token'))) {
            if ($collectionCategory->getPicture()) {
                $uploadCollectionCategory->remove($collectionCategory->getPicture());
            }
            $entityManager->remove($collectionCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('collection_category_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller\Admin\Collection;

use App\Entity\CollectionSubcategory;
use App\Form\Admin\CollectionSubcategoryType;
use App\Repository\CollectionSubcategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/collection-subcategory-admin")
 * @IsGranted("ROLE_ADMIN")
 */
class CollectionSubcategoryAdminController extends AbstractController
{
    /**
     * @Route("/", name="collection_subcategory_admin_index", methods={"GET"})
     */
    public function index(CollectionSubcategoryRepository $collectionSubcategoryRepository): Response
    {
        return $this->render('admin/collection/collection_subcategory_admin/index.html.twig', [
            'collection_subcategories' => $collectionSubcategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="collection_subcategory_admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $collectionSubcategory = new CollectionSubcategory();
        $form = $this->createForm(CollectionSubcategoryType::class, $collectionSubcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($collectionSubcategory);
            $entityManager->flush();

            return $this->redirectToRoute('collection_subcategory_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/collection/collection_subcategory_admin/new.html.twig', [
            'collection_subcategory' => $collectionSubcategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collection_subcategory_admin_show", methods={"GET"})
     */
    public function show(CollectionSubcategory $collectionSubcategory): Response
    {
        return $this->render('admin/collection/collection_subcategory_admin/show.html.twig', [
            'collection_subcategory' => $collectionSubcategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="collection_subcategory_admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CollectionSubcategory $collectionSubcategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CollectionSubcategoryType::class, $collectionSubcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('collection_subcategory_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/collection/collection_subcategory_admin/edit.html.twig', [
            'collection_subcategory' => $collectionSubcategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collection_subcategory_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, CollectionSubcategory $collectionSubcategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collectionSubcategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($collectionSubcategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('collection_subcategory_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}

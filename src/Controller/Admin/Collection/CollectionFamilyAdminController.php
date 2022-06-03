<?php

namespace App\Controller\Admin\Collection;

use App\Entity\CollectionFamily;
use App\Form\CollectionFamilyType;
use App\Repository\CollectionFamilyRepository;
use App\Service\UploadCollectionFamily;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/zone-admin/collection-family-admin")
 * @IsGranted("ROLE_ADMIN")
 */
class CollectionFamilyAdminController extends AbstractController
{
    /**
     * @Route("/", name="collection_family_admin_index", methods={"GET"})
     */
    public function index(CollectionFamilyRepository $collectionFamilyRepository): Response
    {
        return $this->render('admin/collection/collection_family_admin/index.html.twig', [
            'collection_families' => $collectionFamilyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="collection_family_admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, UploadCollectionFamily $uploadCollectionFamily): Response
    {
        $collectionFamily = new CollectionFamily();
        $form = $this->createForm(CollectionFamilyType::class, $collectionFamily);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form->get('picture')->getData()) {
                $fileName = $uploadCollectionFamily->upload($image);
                //Mets a jour l'entite
                $collectionFamily->setPicture($fileName);
            }
            $entityManager->persist($collectionFamily);
            $entityManager->flush();

            return $this->redirectToRoute('collection_family_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/collection/collection_family_admin/new.html.twig', [
            'collection_family' => $collectionFamily,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collection_family_admin_show", methods={"GET"})
     */
    public function show(CollectionFamily $collectionFamily): Response
    {
        return $this->render('admin/collection/collection_family_admin/show.html.twig', [
            'collection_family' => $collectionFamily,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="collection_family_admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CollectionFamily $collectionFamily, EntityManagerInterface $entityManager,
    UploadCollectionFamily $uploadCollectionFamily): Response
    {
        $form = $this->createForm(CollectionFamilyType::class, $collectionFamily);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form->get('picture')->getData()) {
                // Supprimer l'image deja existante
                if ($collectionFamily->getPicture()) {
                    $uploadCollectionFamily->remove($collectionFamily->getPicture());
                }
                $fileName = $uploadCollectionFamily->upload($image);
                //Mets a jour l'entite
                $collectionFamily->setPicture($fileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('collection_family_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/collection/collection_family_admin/edit.html.twig', [
            'collection_family' => $collectionFamily,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collection_family_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, CollectionFamily $collectionFamily, EntityManagerInterface $entityManager,
    UploadCollectionFamily $uploadCollectionFamily): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collectionFamily->getId(), $request->request->get('_token'))) {
            if ($collectionFamily->getPicture()) {
                $uploadCollectionFamily->remove($collectionFamily->getPicture());
            }
            $entityManager->remove($collectionFamily);
            $entityManager->flush();
        }

        return $this->redirectToRoute('collection_family_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}

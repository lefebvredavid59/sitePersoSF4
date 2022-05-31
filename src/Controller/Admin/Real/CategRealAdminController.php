<?php

namespace App\Controller\Admin\Real;

use App\Entity\CategReal;
use App\Form\Admin\Real\CategRealType;
use App\Repository\CategRealRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categ-real")
 * @IsGranted("ROLE_ADMIN")
 */
class CategRealAdminController extends AbstractController
{
    /**
     * @Route("/", name="categ_real_admin_index", methods={"GET"})
     */
    public function index(CategRealRepository $categRealRepository): Response
    {
        return $this->render('admin/Real/categ_real_admin/index.html.twig', [
            'categ_reals' => $categRealRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categ_real_admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categReal = new CategReal();
        $form = $this->createForm(CategRealType::class, $categReal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categReal);
            $entityManager->flush();

            return $this->redirectToRoute('categ_real_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/Real/categ_real_admin/new.html.twig', [
            'categ_real' => $categReal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categ_real_admin_show", methods={"GET"})
     */
    public function show(CategReal $categReal): Response
    {
        return $this->render('admin/Real/categ_real_admin/show.html.twig', [
            'categ_real' => $categReal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categ_real_admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CategReal $categReal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategRealType::class, $categReal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('categ_real_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/Real/categ_real_admin/edit.html.twig', [
            'categ_real' => $categReal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categ_real_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, CategReal $categReal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categReal->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categReal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categ_real_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}

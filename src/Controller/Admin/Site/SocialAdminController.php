<?php

namespace App\Controller\Admin\Site;

use App\Entity\Social;
use App\Form\Admin\SocialType;
use App\Repository\SocialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/social-admin")
 * @IsGranted("ROLE_ADMIN")
 */
class SocialAdminController extends AbstractController
{
    /**
     * @Route("/", name="social_admin_index", methods={"GET"})
     */
    public function index(SocialRepository $socialRepository): Response
    {
        return $this->render('admin/site/social_admin/index.html.twig', [
            'socials' => $socialRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="social_admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $social = new Social();
        $form = $this->createForm(SocialType::class, $social);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($social);
            $entityManager->flush();

            return $this->redirectToRoute('social_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/site/social_admin/new.html.twig', [
            'social' => $social,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="social_admin_show", methods={"GET"})
     */
    public function show(Social $social): Response
    {
        return $this->render('admin/site/social_admin/show.html.twig', [
            'social' => $social,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="social_admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Social $social, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SocialType::class, $social);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('social_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/site/social_admin/edit.html.twig', [
            'social' => $social,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="social_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, Social $social, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$social->getId(), $request->request->get('_token'))) {
            $entityManager->remove($social);
            $entityManager->flush();
        }

        return $this->redirectToRoute('social_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}

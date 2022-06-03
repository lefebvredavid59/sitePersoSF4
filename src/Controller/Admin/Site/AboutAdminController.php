<?php

namespace App\Controller\Admin\Site;

use App\Entity\About;
use App\Form\Admin\Site\AboutType;
use App\Repository\AboutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/zone-admin/about-admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AboutAdminController extends AbstractController
{
    /**
     * @Route("/", name="about_admin_index", methods={"GET"})
     */
    public function index(AboutRepository $aboutRepository): Response
    {
        return $this->render('admin/site/about_admin/index.html.twig', [
            'abouts' => $aboutRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="about_admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $about = new About();
        $form = $this->createForm(AboutType::class, $about);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($about);
            $entityManager->flush();

            return $this->redirectToRoute('about_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/site/about_admin/new.html.twig', [
            'about' => $about,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="about_admin_show", methods={"GET"})
     */
    public function show(About $about): Response
    {
        return $this->render('admin/site/about_admin/show.html.twig', [
            'about' => $about,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="about_admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, About $about, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AboutType::class, $about);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('about_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/site/about_admin/edit.html.twig', [
            'about' => $about,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="about_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, About $about, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$about->getId(), $request->request->get('_token'))) {
            $entityManager->remove($about);
            $entityManager->flush();
        }

        return $this->redirectToRoute('about_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}

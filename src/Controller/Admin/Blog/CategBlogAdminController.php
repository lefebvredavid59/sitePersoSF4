<?php

namespace App\Controller\Admin\Blog;

use App\Entity\CategBlog;
use App\Form\Admin\CategBlogType;
use App\Repository\CategBlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categ-blog")
 * @IsGranted("ROLE_ADMIN")
 */
class CategBlogAdminController extends AbstractController
{
    /**
     * @Route("/", name="categ_blog_admin_index", methods={"GET"})
     */
    public function index(CategBlogRepository $categBlogRepository): Response
    {
        return $this->render('admin/blog/categ_blog_admin/index.html.twig', [
            'categ_blogs' => $categBlogRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categ_blog_admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categBlog = new CategBlog();
        $form = $this->createForm(CategBlogType::class, $categBlog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categBlog);
            $entityManager->flush();

            return $this->redirectToRoute('categ_blog_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/blog/categ_blog_admin/new.html.twig', [
            'categ_blog' => $categBlog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categ_blog_admin_show", methods={"GET"})
     */
    public function show(CategBlog $categBlog): Response
    {
        return $this->render('admin/blog/categ_blog_admin/show.html.twig', [
            'categ_blog' => $categBlog,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categ_blog_admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CategBlog $categBlog, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategBlogType::class, $categBlog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('categ_blog_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/blog/categ_blog_admin/edit.html.twig', [
            'categ_blog' => $categBlog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categ_blog_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, CategBlog $categBlog, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categBlog->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categBlog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categ_blog_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}

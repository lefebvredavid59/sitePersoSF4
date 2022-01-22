<?php

namespace App\Controller\Admin\Blog;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\ArticleUpdateType;
use App\Repository\ArticleRepository;
use App\Service\UploadArticle;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article-blog")
 * @IsGranted("ROLE_ADMIN")
 */
class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/", name="article_admin_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('admin/blog/article_admin/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="article_admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,
                        UploadArticle $uploadArticle): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCreated(new \DateTime('now'));
            if ($image = $form->get('picture')->getData()){
                $fileName = $uploadArticle->upload($image,$article);
                //Mets a jour l'entite
                    $article->setPicture($fileName);
            }
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/blog/article_admin/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_admin_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('admin/blog/article_admin/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager,
                         UploadArticle $uploadArticle): Response
    {
        $form = $this->createForm(ArticleUpdateType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form->get('picture')->getData()) {
                // Supprimer l'image deja existante
                if ($article->getPicture()) {
                    $uploadArticle->remove($article->getPicture());
                }
                $fileName = $uploadArticle->upload($image,$article);
                //Mets a jour l'entite
                $article->setPicture($fileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('article_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/blog/article_admin/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager,
                           UploadArticle $uploadArticle): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $uploadArticle->remove($article->getPicture());
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}

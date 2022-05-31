<?php

namespace App\Controller\Blog;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog/{page}", name="blog")
     */
    public function blog_home($page = 1, ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->article($page);
        $maxPage = ceil(count($articles) / 5);

        return $this->render('site/blog/blog_home.html.twig', [
            'articles' => $articles,
            'current_page' => $page,
            'max_page' => $maxPage,
        ]);
    }

    /**
     * @Route("/category/{slug}/{page}", name="blog_categ")
     */
    public function blog_categ_home($page = 1, $slug, ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->articleCateg($slug, $page);
        $maxPage = ceil(count($articles) / 5);

        return $this->render('site/blog/blog_home.html.twig', [
            'articles' => $articles,
            'current_page' => $page,
            'max_page' => $maxPage,
        ]);
    }

    /**
     * @Route("/blog/article/{slug}", name="blog_article")
     */
    public function blog_article(Article $article): Response
    {
        return $this->render('site/blog/article_view.html.twig', [
            'article' => $article,
        ]);
    }
}

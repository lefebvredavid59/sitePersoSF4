<?php

namespace App\Controller\Site\Blog;

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
    public function index($page = 1 , ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->article($page);
        $maxPage = ceil(count($articles) / 2);

        return $this->render('site/blog/blog_home.html.twig', [
            'articles' => $articles,
            'current_page' => $page,
            'max_page' => $maxPage,
        ]);
    }
}

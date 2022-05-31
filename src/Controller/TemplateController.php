<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategBlogRepository;
use App\Repository\RealisationRepository;
use App\Repository\SocialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TemplateController extends AbstractController
{
    public function header(ArticleRepository $articleRepository, RealisationRepository $realisationRepository): Response
    {
        return $this->render('template/header.html.twig', [
            'blogs' => $articleRepository->findAll(),
            'reals' => $realisationRepository->findAll(),
        ]);
    }

    public function footer(SocialRepository $socialRepository): Response
    {
        return $this->render('template/footer.html.twig', [
            'socials' => $socialRepository->findAll(),
        ]);
    }

    public function categright(CategBlogRepository $categBlogRepository, ArticleRepository $articleRepository): Response
    {
        return $this->render('template/category.html.twig', [
            'categs' => $categBlogRepository->categBlog(),
            'randArt' => $articleRepository->articleRand(3)
        ]);
    }
}

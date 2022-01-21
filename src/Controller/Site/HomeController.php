<?php

namespace App\Controller\Site;

use App\Repository\ArticleRepository;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SiteRepository $siteRepository, ArticleRepository $articleRepository): Response
    {
        return $this->render('site/home/home.html.twig', [
            'dispos' => $siteRepository->findAll(),
            'articles' => $articleRepository->articleHome(),
        ]);
    }
}

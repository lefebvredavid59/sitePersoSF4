<?php

namespace App\Controller\Site;

use App\Repository\ArticleRepository;
use App\Repository\SiteRepository;
use App\Repository\SocialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(SiteRepository $siteRepository, ArticleRepository $articleRepository): Response
    {
        return $this->render('site/home/home.html.twig', [
            'dispos' => $siteRepository->findAll(),
            'articles' => $articleRepository->articleHome(),
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(SocialRepository $socialRepository): Response
    {
        return $this->render('site/about/about.html.twig', [
            'socials' => $socialRepository->findAll(),
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('site/about/about.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }
}

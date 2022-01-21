<?php

namespace App\Controller;

use App\Repository\CategBlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateController extends AbstractController
{
    public function header(): Response
    {
        return $this->render('template/header.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    public function footer(): Response
    {
        return $this->render('template/footer.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    public function categright(CategBlogRepository $categBlogRepository): Response
    {
        return $this->render('template/category.html.twig', [
            'categs' => $categBlogRepository->categBlog(),
        ]);
    }
}

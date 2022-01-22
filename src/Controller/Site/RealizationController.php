<?php

namespace App\Controller\Site;

use App\Repository\RealisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RealizationController extends AbstractController
{
    /**
     * @Route("/realization", name="realization")
     */
    public function index(RealisationRepository $realisationRepository): Response
    {
        return $this->render('site/realization/realization.html.twig', [
            'reals' => $realisationRepository->findAll(),
        ]);
    }
}

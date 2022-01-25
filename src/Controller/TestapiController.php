<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TestapiController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/testapi", name="testapi")
     */
    public function index(): Response
    {
        $response = $this->client->request(
            'GET',
            'https://lefebvredavid.fr/api/categ_blogs.json', [
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]
        );

        return $this->render('testapi/index.html.twig', [
            'categs' => $response,
        ]);
    }
}

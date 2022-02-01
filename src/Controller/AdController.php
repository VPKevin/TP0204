<?php

namespace App\Controller;

use App\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    #[Route('/ads', name: 'ads')]
    public function index(AdRepository $repository): Response
    {
        return $this->render('ads/index.html.twig', [
            'controller_name' => 'AdsController'
        ]);
    }

    #[Route('/ads/show', name: 'ads')]
    public function show()
    {
        return $this->render('ads/show.html.twig', [
            'controller_name' => 'AdsController',
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WelcomepageController extends AbstractController
{
    #[Route('/', name: 'app_welcomepage')]
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'WelcomepageController',
        ]);
    }
}

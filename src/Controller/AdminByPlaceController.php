<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminByPlaceController extends AbstractController
{
    #[Route('/admin/by/place', name: 'app_admin_by_place')]
    public function index(): Response
    {
        return $this->render('admin_by_place/index.html.twig', [
            'controller_name' => 'AdminByPlaceController',
        ]);
    }
}

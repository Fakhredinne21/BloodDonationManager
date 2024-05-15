<?php

namespace App\Controller;

use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WelcomepageController extends AbstractController
{
    private ActivityRepository $activityRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ActivityRepository $activityRepository , EntityManagerInterface $entityManager)
    {
        $this->activityRepository = $activityRepository;
        $this->entityManager = $entityManager;

    }
    #[Route('/', name: 'app_welcomepage')]
    public function index(): Response
    {
        $activities = $this->activityRepository->findAllActivities();
        return $this->render('welcomepage/index.html.twig', [
            'activities' => $activities,
        ]);

    }
}

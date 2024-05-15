<?php

namespace App\Controller;
use App\Entity\Admin;
use App\Entity\Donor;
use App\Entity\Nurse;

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
//    #[Route('/', name: 'app_welcomepage')]
//    public function index(): Response
//    {
//        $activities = $this->activityRepository->findAllActivities();
//        return $this->render('welcomepage/index.html.twig', [
//            'activities' => $activities,
//        ]);
//
//
//    }



    #[Route('/', name: 'app_welcomepage')]
    public function index(): Response
    {
        $activities = $this->activityRepository->findAllActivities();
        // Get the currently authenticated user
        $user = $this->getUser();

        // Check if the user is authenticated
        if ($user) {
            // The user is authenticated
            $roles = $user->getRoles();
            $userId = $user->getId();

            if (in_array('ROLE_ADMIN', $roles)) {
                // Fetch the corresponding admin user with the same user_id
                $adminRepository = $this->entityManager->getRepository(Admin::class);
                $sameIdUser = $adminRepository->findOneBy(['user' => $userId]);
            } elseif (in_array('ROLE_NURSE', $roles)) {
                // Fetch the corresponding nurse user with the same user_id
                $nurseRepository = $this->entityManager->getRepository(Nurse::class);
                $sameIdUser = $nurseRepository->findOneBy(['user' => $userId]);
            } elseif (in_array('ROLE_DONOR', $roles)) {
                // Fetch the corresponding donor user with the same user_id
                $donorRepository = $this->entityManager->getRepository(Donor::class);
                $sameIdUser = $donorRepository->findOneBy(['user' => $userId]);
            } else {
                // The user does not have the required role
                // Render the template without passing the user
                return $this->render('welcomepage/index.html.twig', [
                    'controller_name' => 'WelcomepageController',
                ]);
            }

            // Pass the user object to the template
            return $this->render('welcomepage/index.html.twig', [
                'controller_name' => 'WelcomepageController',
                'user' => $sameIdUser,
                'activities' => $activities,
            ]);
        } else {
            // The user is not authenticated
            // Render the template without passing the user
            return $this->render('welcomepage/index.html.twig', [
                'controller_name' => 'WelcomepageController',
                'activities' => $activities,
            ]);
        }
    }

}

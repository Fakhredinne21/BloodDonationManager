<?php

namespace App\Controller;
use AllowDynamicProperties;
use App\Entity\Admin;
use App\Entity\Donor;
use App\Entity\Nurse;
use http\Env\Request;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Notifier\Notification\Notification;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Notifier\NotifierInterface;

#[AllowDynamicProperties] class WelcomepageController extends AbstractController
{


    private ActivityRepository $activityRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ActivityRepository $activityRepository , EntityManagerInterface $entityManager,NotifierInterface $notifier)
    {
        $this->activityRepository = $activityRepository;
        $this->entityManager = $entityManager;
        $this->notifier = $notifier;
    }
    #[Route('/push', name: 'app_welcomepage')]
    public function push(Request $request)
    {


    }


    #[Route('/', name: 'app_welcomepage')]
    public function index(): Response
    {
        $activities = $this->activityRepository->findAllActivities();
        // Get the currently authenticated user
        $user = $this->getUser();
        $notification = (new Notification('Important Update'))
            ->content('A new feature has been released!')
            ->channels(['email', 'sms']);

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
            return $this->render('base.html.twig', [
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

<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Participation;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request; // Add this line

#[Route('/admin')]
class ActivityController extends AbstractController
{
    private ActivityRepository $activityRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ActivityRepository $activityRepository , EntityManagerInterface $entityManager)
    {
        $this->activityRepository = $activityRepository;
        $this->entityManager = $entityManager;

    }
    #[Route('/activity', name: 'app_activity')]
    public function index(): Response
    {
        return $this->render('activity/index.html.twig', [
            'controller_name' => 'ActivityController',
        ]);
    }

    #[Route('/activity/show/{id}', name: 'activity_show')]
    public function showActivity(int $id): Response
    {
        $activity = $this->entityManager->getRepository(Activity::class)->find($id);
        $participations = $this->entityManager->getRepository(Participation::class)->findAll();
        if (!$activity) {
            throw $this->createNotFoundException('The activity does not exist');
        }

        $donors = $activity->getDonors();

        return $this->render('activity/show.html.twig', [
            'activity' => $activity,
            'donors' => $donors,
            'participations' => $participations,
        ]);
    }

    #[Route('/activity/showallactivities', name: 'app_showallactivities')]
    public function showallactivites(): Response
    {
        $activities = $this->activityRepository->findAllActivities();
        return $this->render('activity/showallactivities.html.twig', [
            'activities' => $activities,
        ]);
    }
    #[Route('/activity/add', name: 'activity_new', methods: ['GET', 'POST'])]
    public function add(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $activity = new Activity();
            $activity->setDate(new \DateTime($data['activity_date']));
            $activity->setStatus($data['activity_status']);

            $this->entityManager->persist($activity);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_showallactivities');
        }

        // Render the form for GET requests
        return $this->render('activity/add_form.html.twig');
    }

    #[Route('/activity/delete/{id}', name: 'activity_delete', methods: ['GET', 'POST'])]
    public function delete(int $id, Request $request): Response
    {
        $activity = $this->activityRepository->find($id);
        $this->activityRepository->deleteActivity($activity);

        return $this->redirectToRoute('app_showallactivities');
    }

    #[Route('/activity/edit/{id}', name: 'activity_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id): Response
    {
        $activity = $this->activityRepository->find($id);

        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $activity->setDate(new \DateTime($data['activity_date']));
            $activity->setStatus($data['activity_status']);

            $this->activityRepository->updateActivity($activity);

            return $this->redirectToRoute('app_showallactivities');
        }

        return $this->render('activity/edit_form.html.twig', [
            'activity' => $activity,
        ]);

    }
}

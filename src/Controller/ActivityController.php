<?php

namespace App\Controller;

use App\Repository\ActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request; // Add this line


class ActivityController extends AbstractController
{
    private ActivityRepository $activityRepository;

    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }
    #[Route('/activity', name: 'app_activity')]
    public function index(): Response
    {
        return $this->render('activity/index.html.twig', [
            'controller_name' => 'ActivityController',
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

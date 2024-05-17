<?php

namespace App\Controller;

use App\Entity\Participation;
use App\Repository\ActivityRepository;
use App\Repository\DonorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DonorController extends AbstractController
{
    private ActivityRepository $activityRepository;
    private EntityManagerInterface $entityManager;
    private DonorRepository $donorRepository;

    public function __construct(ActivityRepository $activityRepository , EntityManagerInterface $entityManager, DonorRepository $donorRepository)
    {
        $this->donorRepository=$donorRepository;
        $this->activityRepository = $activityRepository;
        $this->entityManager = $entityManager;

    }
    #[Route('/donor', name: 'app_donor')]
    public function index(): Response
    {
        return $this->render('donor/index.html.twig', [
            'controller_name' => 'DonorController',
        ]);
    }
    #[Route('/donor/participation{id}', name: 'app_participation')]
    public function participate($id): Response
    {
        $activity = $this->activityRepository->find($id);

        return $this->render('donor/index.html.twig',
            ['activity'=>$activity,
            'controller_name' => 'DonorController',
        ]);

    }
    #[Route('/donor/participation/confirmation{idact}/{id}', name: 'app_confirm_participation')]
    public function confirm(int $idact, int $id): Response
    {
        $activity = $this->activityRepository->find($idact);
        $donor = $this->donorRepository->findOneBy(['user' => $id]);

        // Create a new Participation
        $participation = new Participation();
        $participation->setActivity($activity);
        $participation->setDonor($donor);
        $participation->setAdminByPlace($activity->getAdminByPlace());
        $participation->setConfirmedNurse($activity->getNurses()->first());
        $activity->addDonor($donor);
        $donor->setParticipation($participation);
        foreach ($activity->getNurses() as $nurse){
            $participation->addPossibleNurse($nurse);
        }
        // Add the Participation to the Activity and the Donor
        $activity->addParticipationsActivity($participation);
        $donor->addParticipationsDonor($participation);

        // Persist and flush the Participation
        $this->entityManager->persist($participation);
        $this->entityManager->persist($activity);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_welcomepage');
    }

}

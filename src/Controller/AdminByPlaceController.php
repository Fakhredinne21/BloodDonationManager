<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Adminbyplace;
use App\Entity\Participation;
use App\Form\ActivityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/adminbp')]
class AdminByPlaceController extends AbstractController
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_adminplace')]
    public function index(): Response
    {

        $activities = $this->entityManager->getRepository(Activity::class)->findBy(['adminbyplace' => $this->getUser()]);
        return $this->render('admin_by_place/index.html.twig', [
            'controller_name' => 'adminplaceController',
            'activities' => $activities,
        ]);
    }

    #[Route('/participate/{userId}/{activityId}/participations', name: 'app_participations_donors')]
    public function getParticipations($userId ,$activityId )
    {
        $userIdAdmin = $this->entityManager->getRepository(Adminbyplace::class)->findOneBy(['user' => $userId]);
        $activities = $this->entityManager->getRepository(Activity::class)->findBy(['adminbyplace' => $userIdAdmin, 'id' => $activityId]);

        $participations = [];
        foreach ($activities as $activity) {
            $activityParticipations = $this->   entityManager->getRepository(Participation::class)->findBy(['activity' => $activity, 'confirmedByNurse' => 1]);
            if (empty($activityParticipations)) {
                error_log('No participations found for activity with id: ' . $activity->getId());
            }
            $participations = array_merge($participations, $activityParticipations);
        }

        $donors = [];
        foreach ($participations as $participation) {
            $donor = $participation->getDonor();
            if ($donor === null) {
                error_log('No donor found for participation with id: ' . $participation->getId());
            } else {
                $donors[] = $donor;
            }
        }

        return $this->render('admin_by_place/participations.html.twig', [
            'donors' => $donors,
        ]);
    }
    #[Route('/donor/{id}/validate', name: 'donor_validate')]
    public function validateDonor($id)
    {
        $partcipation = $this->entityManager->getRepository(Participation::class)->find($id);
        if ($partcipation) {
            $partcipation->setConfirmedByAdmin(true);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_participations_donors', ['userId' => $partcipation->getAdminByPlace()->getUser()->getId(), 'activityId' => $partcipation->getActivity()->getId()]);

    }
    #[Route('/donor/{id}/invalidate', name: 'donor_invalidate')]
    public function invalidateDonor($id)
    {
        $partcipation = $this->entityManager->getRepository(Participation::class)->find($id);
        if ($partcipation) {
            $partcipation->setConfirmedByAdmin(false);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_participations_donors', ['userId' => $partcipation->getAdminByPlace()->getUser()->getId(), 'activityId' => $partcipation->getActivity()->getId()]);
    }

    #[Route('/activity/new', name: 'app_activity_new')]
    public function addActivity(Request $request): Response
    {
        $activity = new Activity();
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $loggedInUser = $this->getUser();

            // Fetch the Adminbyplace entity that corresponds to the logged in user
            $adminbyplace = $this->entityManager->getRepository(Adminbyplace::class)->findOneBy(['user' => $loggedInUser]);

            if ($adminbyplace) {
                // Set the adminbyplace field of the Activity with the fetched Adminbyplace entity
                $activity->setAdminbyplace($adminbyplace);

                // Persist and flush the Activity entity
                $this->entityManager->persist($activity);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_adminplace');
            } else {
                // Handle the case where the logged in user is not an Adminbyplace
                // Redirect to a different route or show an error message
            }
        }

        return $this->render('admin_by_place/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/certificate/approve', name: 'app_certificate_approve')]
    public function approveCertificate(Request $request): Response
    {
        $approvedParticipations = $this->entityManager->getRepository(Participation::class)->findBy(['approvedByNurse' => true]);

        foreach ($approvedParticipations as $participation) {
            $donors = $participation->getDonor();

            foreach ($donors as $donor) {
                $isBloodGood = $this->validateBlood($donor->getBloodType());

                $participation->setApproved($isBloodGood);

                $this->entityManager->persist($participation);
            }
        }

        $this->entityManager->flush();

        return $this->redirectToRoute('certificate_index');
    }

    private function validateBlood($blood)
    {
        return (bool)random_int(0, 1);
    }
}

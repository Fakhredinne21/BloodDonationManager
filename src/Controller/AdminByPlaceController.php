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
        return $this->render('admin_by_place/index.html.twig', [
            'controller_name' => 'adminplaceController',
        ]);
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

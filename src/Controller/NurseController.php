<?php

namespace App\Controller;

use App\Entity\Donor;
use App\Entity\Nurse;
use App\Entity\Participation;
use App\Entity\User;
use App\Form\DonorType;
use App\Repository\DonorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/nurse')]
class NurseController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private DonorRepository $donorRepository;

    public function __construct(DonorRepository $donorRepo, EntityManagerInterface $entityManager)
    {
        $donorRepository = $donorRepo;
        $this->entityManager = $entityManager;

    }

    #[Route('/', name: 'app_nurse')]
    public function index(): Response
    {
        $loggedInUser = $this->getUser();

        $nurse = $this->entityManager->getRepository(Nurse::class)->findOneBy(['user' => $loggedInUser]);

        $activities = [];
        if ($nurse) {
            $activities = $nurse->getActivities();
        }

        return $this->render('nurse/index.html.twig', [
            'activities' => $activities,
        ]);
    }

    #[Route('/adddonor', name: 'app_adddonor')]
    public function addDonor(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $donor = new Donor();

        $form = $this->createForm(DonorType::class, $donor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $user->setEmail($form->get('email')->getData());
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(['ROLE_DONOR']);

            $donor->setUser($user);

            $this->entityManager->persist($user);
            $this->entityManager->persist($donor);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_welcomepage');
        }
        return $this->render('nurse/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/participation/approve/{id}', name: 'approve_participation', methods: ['POST'])]
    public function approve(int $id): Response
    {
        $participation = $this->entityManager->getRepository(Participation::class)->find($id);
        if ($participation) {
            $participation->setConfirmedByNurse(true);
            $this->entityManager->persist($participation);
            $this->entityManager->flush();
            return $this->redirectToRoute('activity_show', ['id' => $participation->getActivity()->getId()]);
        }

        throw $this->createNotFoundException('The participation does not exist');
    }
//    #[Route('/approve', name: 'app_nurse_approve')]
//    public function approve(Request $request): Response
//    {
//        $form = $this->createForm(ApprovalType::class);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $data = $form->getData();
//            $participations = $data['participations'];
//            $approved = $data['approved'];
//
//            foreach ($participations as $participation) {
//                $participation->setApproved($approved);
//                $this->getDoctrine()->getManager()->flush();
//            }
//
//            return $this->redirectToRoute('approve');
//        }
//
//        return $this->render('nurse/approve.html.twig', [
//            'form' => $form->createView(),
//        ]);
//    }
}
<?php

namespace App\Controller;

use App\Entity\Donor;
use App\Entity\User;
use App\Form\DonorType;
use App\Repository\DonorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class NurseController extends AbstractController
{ private EntityManagerInterface $entityManager;
    private DonorRepository $donorRepository;

    public function __construct(DonorRepository $donorRepo, EntityManagerInterface $entityManager)
    {
        $donorRepository=$donorRepo;
        $this->entityManager=$entityManager;

    }

    #[Route('/nurse', name: 'app_nurse')]
    public function index(): Response
    {
        return $this->render('nurse/index.html.twig', [
            'controller_name' => 'NurseController',
        ]);
    }
    #[Route('/nurse/adddonor', name: 'app_adddonor')]
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

            return $this->redirectToRoute('app_nurse');
        }
        return $this->render('nurse/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }}

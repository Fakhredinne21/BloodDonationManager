<?php

namespace App\Controller;

use App\Entity\Donor;
use App\Form\DonorType;
use App\Repository\ActivityRepository;
use App\Repository\DonorRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
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
        $donor=new Donor();
        $form = $this->createForm(DonorType::class, $donor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            $this->getUser()->setPassword(
               $userPasswordHasher->hashPassword(
                    $donor->getUser(),
                    $form->get('plainPassword')->getData()
                )
            );
            $donor = $form->getData();
            $this->entityManager->persist($donor);
            $this->entityManager->flush();
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('nurse/index.html.twig');
        }
        return $this->render('nurse/add.html.twig', [
            'form' => $form,
        ]);
    }

}

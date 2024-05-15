<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Entity\Donor;
use App\Entity\User;
use App\Form\DonorType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[AllowDynamicProperties] class RegistrationController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
{
    $this->entityManager=$entityManager;
}
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
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
}

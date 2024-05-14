<?php

namespace App\Controller;

use App\Entity\Nurse;
use App\Entity\User;
use App\Form\NurseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class AdminController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/admin/add-nurse', name: 'app_admin_add_nurse')]
public function addNurse(Request $request, UserPasswordHasherInterface $passwordEncoder): Response
{
    $nurse = new Nurse();
    $user = new User();

    $form = $this->createForm(NurseType::class, $nurse);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Set the corresponding values for the User entity
        $user->setEmail($nurse->getEmail());
        $user->setPassword($passwordEncoder->hashPassword($user, $form->get('password')->getData()));
        $user->setRoles(['ROLE_NURSE']); // set the role for the user

        $this->entityManager->persist($nurse);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    return $this->render('admin/add_nurse.html.twig', [
        'form' => $form->createView(),
    ]);
}
}
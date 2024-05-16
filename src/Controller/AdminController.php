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
    public function addNurse(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $nurse = new Nurse();

        $form = $this->createForm(NurseType::class, $nurse);
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
            $user->setRoles(['ROLE_NURSE']);

            // Persist and flush the User entity first so it gets an ID
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Now that the User entity has an ID, you can set it in the Nurse entity
            $nurse->setUser($user);

            // Persist and flush the Nurse entity
            $this->entityManager->persist($nurse);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }
        return $this->render('admin/add_nurse.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
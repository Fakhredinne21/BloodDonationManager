<?php

namespace App\Controller;

use App\Entity\Donor;
use App\Entity\Participation;
use App\Form\ParticipationsType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ParticipationsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/participations', name: 'app_participations')]
    public function index(): Response
    {

        return $this->render('participations/index.html.twig', [
            'controller_name' => 'ParticipationsController',
        ]);
    }
    #[Route('/participations/new', name: 'app_participations_new')]
    public function new(Request $request): Response
    {
        $participation = new Participation();
        $form = $this->createForm(ParticipationsType::class, $participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            if($user instanceof Donor) {
                $participation->addDonor($this->getUser());
                $this->entityManager->persist($participation);
                $this->entityManager->flush();
                return $this->redirectToRoute('participation_index');
            }
        }

        return $this->render('participation/new.html.twig', [
            'participation' => $participation,
            'form' => $form->createView(),
        ]);
    }
}

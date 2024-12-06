<?php

namespace App\Controller;

use App\Entity\Animator;
use App\Form\AnimatorType;
use App\Repository\AnimatorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnimatorController extends AbstractController
{

    //ACCUEIL ANIMATORS

    #[Route('/animators', name: 'animators')]
    public function index(AnimatorRepository $animatorRepository): Response
    {

        $animators = $animatorRepository->findAll();

        return $this->render('animator/index.html.twig', [
            'animators' => $animators,
        ]);
    }

    //FONCTION AJOUTER UN ANIMATEUR

    #[Route('/animators/create', name: 'animators_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        $animators = new Animator();

        $form = $this->createForm(AnimatorType::class, $animators);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $entityManager->persist($animators);
            $entityManager->flush();

            return $this->redirectToRoute('animators_create');
        }

        $form_view = $form->createView();

        return $this->render('animator/create.html.twig', [
            'form_view' => $form_view,
        ]);
    }
}

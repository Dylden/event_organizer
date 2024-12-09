<?php

namespace App\Controller;

use App\Entity\Animator;
use App\Form\AnimatorType;
use App\Form\TagType;
use App\Repository\AnimatorRepository;
use App\Repository\TagRepository;
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

    //FONCTION UPDATE UNE CATEGORIE

    #[Route('/animators/{id}/update', name: 'animators_update', requirements: ['id' => '\d+'])]
    public function update(int $id, AnimatorRepository $animatorRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $animators = $animatorRepository->find($id);

        $form_view = $this->createForm(AnimatorType::class, $animators);

        $form_view->handleRequest($request);

        if ($form_view->isSubmitted()) {
            $entityManager->persist($animators);
            $entityManager->flush();

            return $this->redirectToRoute('animators_update', ['id' => $animators->getId()]);
        }

        return $this->render('animator/update.html.twig', [
            'animators' => $animators,
            'form_view' => $form_view->createView(),
        ]);
    }

    //SUPPRIMER UN TAG

    #[Route('/animators/delete/{id}', 'animators_delete', ['id' => '\d+'])]
    public function remove(int $id, EntityManagerInterface $entityManager, AnimatorRepository $animatorRepository): Response
    {

        $animators = $entityManager->getRepository(AnimatorType::class)->find($id);

        if (!$animators) {
            throw $this->createNotFoundException('Animator not found');
        }

        $entityManager->remove($animators);
        $entityManager->flush();

        return $this->render('animator/delete.html.twig', [
            'animators' => $animators
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Establishment;
use App\Form\EstablishmentType;
use App\Repository\EstablishmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EstablishmentController extends AbstractController
{

    //ACCUEIL ESTABLISHMENTS

    #[Route('/establishments', name: 'establishments')]
    public function index(EstablishmentRepository $establishmentRepository): Response
    {

        $establishments = $establishmentRepository->findAll();

        return $this->render('establishment/index.html.twig', [
            'establishments' => $establishments,
        ]);
    }

    //FONCTION AJOUTER UN ETABLISSEMENT

    #[Route('/establishments/create', name: 'establishments_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        $establishments = new Establishment();

        $form = $this->createForm(EstablishmentType::class, $establishments);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $entityManager->persist($establishments);
            $entityManager->flush();

            return $this->redirectToRoute('establishments_create');
        }

        $form_view = $form->createView();

        return $this->render('establishment/create.html.twig', [
            'form_view' => $form_view,
        ]);
    }
}

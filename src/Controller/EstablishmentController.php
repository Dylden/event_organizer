<?php

namespace App\Controller;

use App\Entity\Establishment;
use App\Entity\Event;
use App\Form\EstablishmentType;
use App\Form\EventType;
use App\Repository\EstablishmentRepository;
use App\Repository\EventRepository;
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

    //FONCTION UPDATE UN ETABLISSEMENT

    #[Route('/establishments/{id}/update', name: 'establishments_update', requirements: ['id' => '\d+'])]
    public function update(int $id, EstablishmentRepository $establishmentRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $establishments = $establishmentRepository->find($id);



        $form_view = $this->createForm(EstablishmentType::class, $establishments);


        $form_view->handleRequest($request);

        if ($form_view->isSubmitted()) {
            $entityManager->persist($establishments);
            $entityManager->flush();

            return $this->redirectToRoute('establishments_update', ['id' => $establishments->getId()]);
        }

        return $this->render('establishment/update.html.twig', [
            'establishments' => $establishments,
            'form_view' => $form_view->createView(),
        ]);
    }

    //SUPPRIMER UN ETABLISSEMENT

    #[Route('/establishments/delete/{id}', 'establishments_delete', ['id' => '\d+'])]
    public function remove(int $id, EntityManagerInterface $entityManager, EventRepository $eventRepository): Response
    {

        $establishments = $entityManager->getRepository(EstablishmentType::class)->find($id);

        if (!$establishments) {
            throw $this->createNotFoundException('Establishment not found');
        }

        $entityManager->remove($establishments);
        $entityManager->flush();

        return $this->render('establishment/delete.html.twig', [
            'establishments' => $establishments
        ]);
    }
}

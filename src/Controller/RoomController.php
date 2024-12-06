<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\ProjectType;
use App\Form\RoomType;
use App\Repository\ProjectRepository;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RoomController extends AbstractController
{

    //ACCUEIL ROOMS

    #[Route('/rooms', name: 'rooms')]
    public function index(RoomRepository $roomRepository): Response
    {

        $rooms = $roomRepository->findAll();

        return $this->render('room/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }

    //FONCTION AJOUTER UNE ROOM

    #[Route('/rooms/create', name: 'rooms_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        $rooms = new Room();

        $form = $this->createForm(RoomType::class, $rooms);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $entityManager->persist($rooms);
            $entityManager->flush();

            return $this->redirectToRoute('rooms_create');
        }

        $form_view = $form->createView();

        return $this->render('room/create.html.twig', [
            'form_view' => $form_view,
        ]);
    }

}



<?php

namespace App\Controller;

use App\Entity\Establishment;
use App\Entity\Image;
use App\Entity\Room;
use App\Form\EstablishmentType;
use App\Form\ProjectType;
use App\Form\RoomType;
use App\Repository\EventRepository;
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

            $images = $form->get('images')->getData();

            foreach ($images as $image) {

                $fileName = md5(uniqid()) . '.' . $image->getClientOriginalExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );


                $image = new Image();
                $image->setPath($this->getParameter('upload_base_url') . '/' . $fileName);
                $image->setRoom($rooms);

                $entityManager->persist($image);
            }

                $entityManager->persist($rooms);
                $entityManager->flush();

                $this->addFlash('success', 'Room created successfully !');
                return $this->redirectToRoute('rooms_create', [], Response::HTTP_SEE_OTHER);

        }

        $form_view = $form->createView();

        return $this->render('room/create.html.twig', [
            'form_view' => $form_view,
            'rooms' => $rooms,
        ]);
    }

    //FONCTION SHOW UNE SALLE

    #[Route('rooms/{id}', name: 'rooms_show', methods: ['GET'])]
    public function show(Room $rooms): Response
    {
        return $this->render('room/show.html.twig', [
            'room' => $rooms,
        ]);
    }


    //FONCTION UPDATE UNE SALLE

    #[Route('/rooms/{id}/update', name: 'rooms_update', requirements: ['id' => '\d+'])]
    public function update(int $id, RoomRepository $roomRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $rooms = $roomRepository->find($id);

        $form_view = $this->createForm(RoomType::class, $rooms);

        $form_view->handleRequest($request);

        if ($form_view->isSubmitted()) {
            $entityManager->persist($rooms);
            $entityManager->flush();

            return $this->redirectToRoute('rooms_update', ['id' => $rooms->getId()]);
        }

        return $this->render('room/update.html.twig', [
            'rooms' => $rooms,
            'form_view' => $form_view->createView(),
        ]);
    }

    //SUPPRIMER UNE SALLE

    #[Route('/rooms/delete/{id}', 'rooms_delete', ['id' => '\d+'])]
    public function remove(int $id, EntityManagerInterface $entityManager, RoomRepository $roomRepository): Response
    {

        $rooms = $entityManager->getRepository(Room::class)->find($id);

        if (!$rooms) {
            throw $this->createNotFoundException('Room not found');
        }

        foreach ($rooms->getImages() as $image) {
            @unlink($this->getParameter('images_directory') . '/' . $image->getFilename());
        }
        $entityManager->remove($rooms);
        $entityManager->flush();

        return $this->render('room/delete.html.twig', [
            'rooms' => $rooms
        ]);
    }
}



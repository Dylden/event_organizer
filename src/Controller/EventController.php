<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{

    //ACCUEIL EVENTS

    #[Route('/events', name: 'events')]
    public function index(EventRepository $eventRepository): Response
    {

        $events = $eventRepository->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }

    //FONCTION AJOUTER UN EVENT

    #[Route('/events/create', name: 'events_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        $events = new Event();

        $form = $this->createForm(EventType::class, $events);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $entityManager->persist($events);
            $entityManager->flush();

            return $this->redirectToRoute('events_create');
        }

        $form_view = $form->createView();

        return $this->render('event/create.html.twig', [
            'form_view' => $form_view,
        ]);
    }
}

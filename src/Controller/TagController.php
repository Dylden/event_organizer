<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TagController extends AbstractController
{

    //ACCUEIL TAGS

    #[Route('/tags', name: 'tags')]
    public function index(TagRepository $tagRepository): Response
    {

        $tags = $tagRepository->findAll();

        return $this->render('tag/index.html.twig', [
            'tags' => $tags,
        ]);
    }

    //FONCTION AJOUTER UN TAG

    #[Route('/tags/create', name: 'tags_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        $tags = new Tag();

        $form = $this->createForm(TagType::class, $tags);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $entityManager->persist($tags);
            $entityManager->flush();

            return $this->redirectToRoute('tags_create');
        }

        $form_view = $form->createView();

        return $this->render('tag/create.html.twig', [
            'form_view' => $form_view,
        ]);
    }
}

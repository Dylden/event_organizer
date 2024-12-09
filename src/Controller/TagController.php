<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\RoomType;
use App\Form\TagType;
use App\Repository\CategoryRepository;
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

    //FONCTION UPDATE UNE CATEGORIE

    #[Route('/tags/{id}/update', name: 'tags_update', requirements: ['id' => '\d+'])]
    public function update(int $id, TagRepository $tagRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $tags = $tagRepository->find($id);

        $form_view = $this->createForm(TagType::class, $tags);

        $form_view->handleRequest($request);

        if ($form_view->isSubmitted()) {
            $entityManager->persist($tags);
            $entityManager->flush();

            return $this->redirectToRoute('tags_update', ['id' => $tags->getId()]);
        }

        return $this->render('tag/update.html.twig', [
            'tags' => $tags,
            'form_view' => $form_view->createView(),
        ]);
    }

    //SUPPRIMER UN TAG

    #[Route('/tags/delete/{id}', 'tags_delete', ['id' => '\d+'])]
    public function remove(int $id, EntityManagerInterface $entityManager, TagRepository $tagRepository): Response
    {

        $tags = $entityManager->getRepository(TagType::class)->find($id);

        if (!$tags) {
            throw $this->createNotFoundException('Tag not found');
        }

        $entityManager->remove($tags);
        $entityManager->flush();

        return $this->render('tag/delete.html.twig', [
            'tags' => $tags
        ]);
    }
}

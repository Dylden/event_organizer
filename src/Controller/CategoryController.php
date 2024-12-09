<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Form\RoomType;
use App\Repository\CategoryRepository;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{

    //ACCUEIL CATEGORIES

    #[Route('/categories', name: 'categories')]
    public function index(CategoryRepository $categoryRepository): Response
    {

        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    //FONCTION AJOUTER UNE CATEGORIE

    #[Route('/categories/create', name: 'categories_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        $categories = new Category();

        $form = $this->createForm(CategoryType::class, $categories);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $entityManager->persist($categories);
            $entityManager->flush();

            return $this->redirectToRoute('categories_create');
        }

        $form_view = $form->createView();

        return $this->render('category/create.html.twig', [
            'form_view' => $form_view,
        ]);
    }

    //FONCTION UPDATE UNE CATEGORIE

    #[Route('/categories/{id}/update', name: 'categories_update', requirements: ['id' => '\d+'])]
    public function update(int $id, CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $categories = $categoryRepository->find($id);

        $form_view = $this->createForm(CategoryType::class, $categories);

        $form_view->handleRequest($request);

        if ($form_view->isSubmitted()) {
            $entityManager->persist($categories);
            $entityManager->flush();

            return $this->redirectToRoute('categories_update', ['id' => $categories->getId()]);
        }

        return $this->render('category/update.html.twig', [
            'categories' => $categories,
            'form_view' => $form_view->createView(),
        ]);
    }

    //SUPPRIMER UNE CATEGORIE

    #[Route('/categories/delete/{id}', 'categories_delete', ['id' => '\d+'])]
    public function remove(int $id, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {

        $categories = $entityManager->getRepository(CategoryType::class)->find($id);

        if (!$categories) {
            throw $this->createNotFoundException('Category not found');
        }

        $entityManager->remove($categories);
        $entityManager->flush();

        return $this->render('category/delete.html.twig', [
            'categories' => $categories
        ]);
    }
}

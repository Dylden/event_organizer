<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
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
}

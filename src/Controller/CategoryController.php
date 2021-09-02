<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="app_category_home")
     */
    public function home(CategoryRepository $cateRepo): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $cateRepo->findAll()
        ]);
    }

    /**
     * @Route("/category/add", name="app_category_add")
     */
    public function add(Request $request, EntityManagerInterface $em): Response
    {

        $category = new Category;

        $CategoryForm = $this->createForm(CategoryType::class, $category);

        $CategoryForm->handleRequest($request);

        if ($CategoryForm->isSubmitted() && $CategoryForm->isValid()) {
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('category/create.html.twig', [
            'CategoryForm' => $CategoryForm->createView()
        ]);
    }

    /**
     * @Route("/category/show/{id}", name="app_category_show")
     */
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig',compact('category'));
    }



    /**
     * @Route("/category/delete/{id}", name="app_category_delete")
     */
    public function deleteCateg(Category $category, EntityManagerInterface $em): Response
    {
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('app_home');
    }
}

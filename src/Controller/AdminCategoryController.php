<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categories", name="admin_category_")
 */
class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     * @param Category $category
     * @return Response
     */
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Category $category
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

//            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/edit.html.twig', [
            'categories' => $categoryRepository->findByCategory($category),
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="delete", methods={"POST"})
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $parentCategory = $category->getCategory();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
            if ($parentCategory) {
                return $this->redirectToRoute('admin_category_edit', ['id' => $parentCategory->getId()]);
            }
        }

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/{id}/modal-new-category", priority=1, name="modal_new")
     * @param Request $request
     * @param int $id
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function modalAddNewCategory(Request $request, int $id, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        if (!$id) {
            $parentCategory = null;
        } else {
            $parentCategory = $categoryRepository->findOneById($id);
        }
        $category->setCategory($parentCategory);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirect($request->headers->get('referer'));
        }
        return $this->render('category/modal-new-category.html.twig', [
            'category' => $parentCategory,
            'form' => $form->createView()
        ]);
    }
}

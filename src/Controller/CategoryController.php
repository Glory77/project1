<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Entity\Category;
use App\Model\CategoryUpdateRequest;
use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/v1')]
class CategoryController extends AbstractController
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    #[Route('/categories', name: 'categories', methods: ['GET'])]
    public function categories(): Response
    {
        return $this->json($this->categoryService->getCategories());
    }

    #[Route('/categories/{id}', name: 'category', methods: ['GET'])]
    public function category(int $id): Response
    {
        return $this->json($this->categoryService->getCategoryById($id));
    }

    #[Route('/categories', name: 'create_category', methods: ['POST'])]
    public function create(Request $request): Response
    {
        return $this->json($this->categoryService->createCategory($request));
    }

    #[Route('/categories/{id}', name: 'update_category', methods: ['POST'])]
    public function update(int $id, Request $request): Response
    {
        return $this->json($this->categoryService->updateCategory($id, $request));
    }

    #[Route('/categories/{id}', name: 'delete_category', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $this->categoryService->deleteCategory($id);
        return $this->json([]);
    }
}

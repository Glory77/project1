<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private ValidatorInterface $validator
    )
    {
    }

    public function getCategories(): array
    {
        return $this->categoryRepository->findAllSortedByTitle();
    }

    public function getCategoryById(int $id): Category
    {
        return $this->categoryRepository->find($id);
    }

    public function createCategory(Request $request): Category | JsonResponse
    {
        $category = new Category();
        return $this->modifyCategory($request, $category);
    }

    public function updateCategory(int $id, Request $request): Category
    {
        $category = $this->categoryRepository->find($id);
        return $this->modifyCategory($request, $category);
    }

    public function deleteCategory(int $id): void
    {
        $category = $this->categoryRepository->find($id);
        $this->categoryRepository->remove($category, true);
    }

    private function modifyCategory(Request $request, Category $category): Category | JsonResponse
    {
        $data = json_decode($request->getContent(), true);;
        $category->setTitle($data['title']);

        $errors = $this->validator->validate($category);
        if ($errors->count() > 0) {
            return new JsonResponse([
                'message' => (string) $errors
            ]);
        }

        $this->categoryRepository->save($category, true);
        return $category;
    }
}
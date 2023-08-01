<?php

namespace App\Service;

use App\Entity\Category;
use App\Model\CategoryUpdateRequest;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;

class CategoryService
{
    public function __construct(private CategoryRepository $categoryRepository)
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

    public function createCategory(Request $request): Category
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

    private function modifyCategory(Request $request, Category $category): Category
    {
        $data = json_decode($request->getContent(), true);;
        $category->setTitle($data['title']);
        $this->categoryRepository->save($category, true);
        return $category;
    }
}
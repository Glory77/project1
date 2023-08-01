<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/v1')]
class CategoryController extends AbstractController
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    #[Route('/categories', name: 'categories', methods: ['GET'])]
    public function categories(): Response
    {
        return $this->json($this->categoryRepository->findAllSortedByTitle());
    }

    #[Route('/categories/{id}', name: 'category', methods: ['GET'])]
    public function category(int $id): Response
    {
        return $this->json($this->categoryRepository->getById($id));
    }
}

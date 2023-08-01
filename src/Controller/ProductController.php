<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/v1')]
class ProductController extends AbstractController
{
    public function __construct(private ProductService $productService)
    {
    }

    #[Route('/categories/{id}/products', name: 'products', methods: ['GET'])]
    public function products(int $id): Response
    {
        return $this->json($this->productService->getProductsByCategory($id));
    }

    #[Route('/products/{id}', name: 'product_details', methods: ['GET'])]
    public function productsDetail(int $id): Response
    {
        return $this->json($this->productService->productDetails($id));
    }

    #[Route('/categories/{id}/products', name: 'product_create', methods: ['POST'])]
    public function create(int $id, Request $request): Response
    {
        return $this->json($this->productService->createProduct($id, $request));
    }

    #[Route('/products/{id}', name: 'product_update', methods: ['POST'])]
    public function update(int $id, Request $request): Response
    {
        return $this->json($this->productService->updateProduct($id, $request));
    }

    #[Route('/products/{id}', name: 'product_delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $this->productService->deleteProduct($id);
        return $this->json([]);
    }
}

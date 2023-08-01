<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository,
        private CategoryRepository $categoryRepository
    )
    {
    }

    public function getProductsByCategory(int $id): array
    {
        return $this->productRepository->findByCategoryId($id);
    }


    public function productDetails(int $id): Product
    {
        return $this->productRepository->find($id);
    }

    public function createProduct(int $id, Request $request): Product
    {
        $product = new Product();
        $category = $this->categoryRepository->find($id);
        $product->setCategory($category);
        return $this->modifyProduct($request, $product);
    }

    public function updateProduct(int $id, Request $request): Product
    {
        $product = $this->productRepository->find($id);
        return $this->modifyProduct($request, $product);
    }

    public function deleteProduct(int $id): void
    {
        $product = $this->productRepository->find($id);
        $this->productRepository->remove($product, true);
    }

    private function modifyProduct(Request $request, Product $product): Product
    {
        $data = json_decode($request->getContent(), true);;
        $product->setTitle($data['title']);
        $product->setActive(true);
        $this->productRepository->save($product, true);
        return $product;
    }
}
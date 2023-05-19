<?php

namespace App\Controller;

use App\Entity\Categories;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function index(EntityManagerInterface $em): Response
    {
        $categories = $em->getRepository(Categories::class)->findAll();
        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',
            'categories' => $categories
        ]);
    }
}

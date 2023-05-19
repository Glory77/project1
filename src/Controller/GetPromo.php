<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetPromo extends AbstractController
{
    public function __invoke(EntityManagerInterface $em)
    {
        $promos = $em->getRepository(Products::class)
            ->findByDateRange();

        if (!$promos) {
            throw $this->createNotFoundException(
                'No promo product found'
            );
        }

        return $promos;
    }
}

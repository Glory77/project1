<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public static array $categories = [
        'Electronics',
        'Home',
        'Sport',
        'Health',
        'Cloths',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::$categories as $category) {
            $entity = new Category();
            $entity->setTitle($category);
            $this->addReference($category, $entity);
            $manager->persist($entity);
        }

        $manager->flush();
    }
}

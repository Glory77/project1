<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = CategoryFixtures::$categories;
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $entity = new Product();
            $entity->setTitle($faker->name);
            $entity->setDescription($faker->text);
            $entity->setPrice($faker->numberBetween(100, 900));
            $categoryReference = $faker->randomElement($categories);
            $category = $this->getReference($categoryReference);
            $entity->setCategory($category);
            $entity->setActive(true);
            $manager->persist($entity);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}

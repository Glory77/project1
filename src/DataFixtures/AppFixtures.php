<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Products;
use Faker\Factory;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    protected \Faker\Generator $faker;
    protected ObjectManager $em;

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $em): void
    {
        $this->em = $em;
        $this->createUsers();
        $this->createCategories();
        $this->createProducts();
    }

    public function createUsers(): void
    {
        $user = new User();
        $user->setPassword($this->passwordHasher->hashPassword($user, 'admin'));
        $user->setEmail('admin@admin.com');
        $user->setRoles(['ROLE_ADMIN']);
        $this->em->persist($user);
        $this->em->flush();
    }

    public function createCategories(): void
    {
        $array = ['Jeans', 'Hoodies', 'Boots', 'Shirts', 'Shoes', 'Trainers'];

        foreach ($array as $value) {
            $category = new Categories();
            $category->setTitle($value);
            $this->em->persist($category);
        }

        $this->em->flush();
    }

    public function createProducts(): void
    {
        $categories = $this->em->getRepository(Categories::class)->findAll();
        if (is_array($categories) && sizeof($categories)>0)
        {
            $this->createMany(Products::class, 100, function(Products $product) use ($categories) {
                $product
                    ->setTitle($this->faker->name)
                    ->setDescription($this->faker->words(5, true))
                    ->setPrice($this->faker->numberBetween(10, 90))
                    ->setPricePromo($this->faker->numberBetween(10, 90))
                    ->setDateFrom($this->faker->dateTimeBetween('-30 days', '+30 days'))
                    ->setDateTo($this->faker->dateTimeBetween('-30 days', '+30 days'))
                    ->setCategory($this->faker->randomElement($categories))
                    ->setActive(1)
                ;
            });

            $this->em->flush();
        }
    }

    protected function createMany(string $className, int $count, callable $factory)
    {
        for ($i = 0; $i < $count; $i++) {
            $entity = new $className();
            $factory($entity, $i);
            $this->em->persist($entity);
            $this->addReference($className . '_' . $i, $entity);
        }
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Génération des catégories mères
        $loop = 5;
        for ($i = 1; $i <= $loop; $i++) {
            $faker = Factory::create();
            $category = new Category();
            $category->setCategory($faker->word());
            $manager->persist($category);
            $this->addReference('categoryM_' . $i, $category);
        }
        $manager->flush();

        $loop = 15;
        for ($i = 1; $i <= $loop; $i++) {
            $category = new Category();
            $category->setCategory($faker->word());
            $category->setCategoryId($this->getReference('categoryM_' . rand(1, 5)));
            $manager->persist($category);
            $this->addReference('category_' . $i, $category);
        }
        $manager->flush();
    }
}

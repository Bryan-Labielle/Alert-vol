<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = ([
            'BTP',
            'engin_de_chantier',
            'Agroalimentaire',
            'Moissonneuse_Bateuse',
            'Nautique',
            'bateau_sans_permis',
    ]);

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $val) {
            $category = new Category();

            $category->setName($val);
            $manager->persist($category);
            $this->addReference('category_' . $key, $category);
        }
            $manager->flush();
    }
}

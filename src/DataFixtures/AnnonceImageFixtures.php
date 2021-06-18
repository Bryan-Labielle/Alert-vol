<?php

namespace App\DataFixtures;

use App\Entity\AnnonceImage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AnnonceImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $loop = 10;
        for ($i = 1; $i <= $loop; $i++) {
            $faker = Factory::create();
            $annonceImage = new AnnonceImage();
            $annonceImage->setImage($faker->image());
            $annonceImage->setAnnonce($this->getReference('annonce_' . rand(1, 30)));
            $manager->persist($annonceImage);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AnnonceFixtures::class
        ];
    }
}

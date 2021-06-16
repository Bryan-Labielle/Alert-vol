<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AnnonceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create();
        //generate data
        $loop = 30;
        for ($i = 1; $i <= $loop; $i++) {
            $annonce = new Annonce();
            $annonce->setTitle($faker->userName() . " " . $faker->city());
            $annonce->setDescription($faker->text());
            $annonce->setPublishedAt($faker->dateTime());
            $annonce->setEndPublishedAt($faker->dateTime());
            $annonce->setStolenAt($faker->dateTime());
            $annonce->setStatus(rand(0, 2));
            $annonce->setReference($faker->randomLetter() . $faker->randomLetter() .
            $faker->numberBetween(000, 999) . $faker->randomLetter() . $faker->randomLetter());
            $annonce->setLocation($faker->numberBetween(10000, 99999));
            $annonce->setDetails(UserFixtures::ARRAYTOJSON);
            //Relations fixtures
            $annonce->setCategory($this->getReference('category_' . rand(1, 15)));
            $annonce->setOwner($this->getReference('user_' . rand(1, 9)));

            $manager->persist($annonce);
            $this->addReference('annonce_' . $i, $annonce);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class
        ];
    }
}

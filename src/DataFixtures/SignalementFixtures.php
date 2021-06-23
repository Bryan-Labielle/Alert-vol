<?php

namespace App\DataFixtures;

use App\Entity\Signalement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SignalementFixtures extends Fixture implements DependentFixtureInterface
{
    public const ARRAYTOJSON = [
        'role' => 'admin',
        'job' => 'accountManager'
    ];
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        //generate data
        $loop = 30;
        for ($i = 1; $i <= $loop; $i++) {
            $signalement = new Signalement();
            $signalement->setdetails(self::ARRAYTOJSON);
            $signalement->setSendAt($faker->dateTime());
            $signalement->setSeenOn($faker->dateTime());
            $signalement->setLatitude($faker->latitude());
            $signalement->setLongitude($faker->longitude());
            // relations fixtures
            $signalement->setOwner($this->getReference('user_' . rand(1, 3)));
            $signalement->setAnnonce($this->getReference('annonce_' . rand(0, 11)));
            // persist, reference, flush
            $manager->persist($signalement);
            $this->addReference('signalement_' . $i, $signalement);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            AnnonceFixtures::class
        ];
    }
}

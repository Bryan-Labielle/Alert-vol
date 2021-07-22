<?php

namespace App\DataFixtures;

use App\Entity\Message;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $loop = 10;
        $faker = Factory::create();
        for ($i = 1; $i <= $loop; $i++) {
            $message = new Message();
            $message->setContent($faker->text());
            $message->setSender($this->getReference('user_' . rand(1, 3)));
            $message->setRecipient($this->getReference('user_' . rand(1, 3)));
            $message->setSentAt($faker->dateTime());
            $message->setSignalement($this->getReference('signalement_' . rand(1, 30)));
            $manager->persist($message);
        }
//        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            SignalementFixtures::class
        ];
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Bookmark;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookmarkFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //generate data
        $loop = 40;
        for ($i = 1; $i <= $loop; $i++) {
            $bookmark = new Bookmark();
        //relations fixtures
            $bookmark->setAnnonce($this->getReference('annonce_' . rand(1, 30)));
            $bookmark->setUser($this->getReference('user_' . rand(1, 3)));
        //persist & flush
            $manager->persist($bookmark);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AnnonceFixtures::class,
            UserFixtures::class
        ];
    }
}

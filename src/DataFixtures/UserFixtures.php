<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public const ARRAYTOJSON = ([
        'role' => 'admin',
        'job' => 'accountManager',
        'age' => '27'
    ]);
    public function load(ObjectManager $manager)
    {
        $loop = 10;
        $faker = Factory::create();
        for ($i = 0; $i <= $loop; $i++) {
            $user = new User();
            $user->setPseudo($faker->name());
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setEmail($faker->email());
            $user->setPassword($faker->password());
            $user->setRole(self::ARRAYTOJSON);
            $user->setAdress($faker->address());
            $user->setZip($faker->numberBetween(10000, 99999));
            $user->setCity($faker->city());
            $user->setAvatar($faker->image());
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}

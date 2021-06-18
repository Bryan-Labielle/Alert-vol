<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public const ROLES = ([
        '1' => 'user',
        '2' => 'admin',
        '3' => 'member'
    ]);
    public const USERS = ([
        'user' => ([
            'pseudo' => 'user',
            'first_name' => 'Dupuis',
            'last_name' => 'Dupont',
            'email' => 'user@test.com',
            'password' => 'user',
            'role' => '1',
        ]),
        'admin' => ([
            'pseudo' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'Istrator',
            'email' => 'admin@test.com',
            'password' => 'admin',
            'role' => '2',
        ]),
        'member' => ([
            'pseudo' => 'member',
            'first_name' => 'member',
            'last_name' => 'Istrator',
            'email' => 'member@test.com',
            'password' => 'member',
            'role' => '3',
        ]),
    ]);

    public function load(ObjectManager $manager)
    {
        /*$loop = 10;
        $faker = Factory::create();
        for ($i = 0; $i <= $loop; $i++) {
            $user = new User();
            $user->setPseudo($faker->name());
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setEmail($faker->email());
            $user->setPassword($faker->password());
            //$user->setRole();
            $user->setAdress($faker->address());
            $user->setZip($faker->numberBetween(10000, 99999));
            $user->setCity($faker->city());
            $user->setAvatar($faker->image());
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }*/
        $int = 0;
        foreach (self::USERS as $key => $val) {
            $user = new User();
            $user->setPseudo($val['pseudo']);
            $user->setFirstName($val['first_name']);
            $user->setLastName($val['last_name']);
            $user->setEmail($val['email']);
            $user->setPassword($val['password']);
            $user->setRole($val['role']);
            $manager->persist($user);
            $num = $int += 1;
            $this->addReference('user_' . $num, $user);
        }
        $manager->flush();
    }
}

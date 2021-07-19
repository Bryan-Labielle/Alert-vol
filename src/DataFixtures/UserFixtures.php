<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $int = 1;
        foreach (self::USERS as $val) {
            $user = new User();
            $user->setPseudo($val['pseudo']);
            $user->setFirstName($val['first_name']);
            $user->setLastName($val['last_name']);
            $user->setEmail($val['email']);
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, $val['password']));
            $user->setRole($val['role']);
            $manager->persist($user);
            $this->addReference('user_' . $int, $user);
            $int += 1;
        }
        $manager->flush();
    }
}

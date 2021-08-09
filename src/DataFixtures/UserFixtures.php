<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $userPasswordEncoder;
    private ParameterBagInterface $parameterBag;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder, ParameterBagInterface $parameterBag)
    {

        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->parameterBag = $parameterBag;
    }
    public function load(ObjectManager $manager)
    {
        $users = [
            'admin' => [
                'pseudo' => 'admin',
                'first_name' => 'Admin',
                'last_name' => 'Istrator',
                'email' => $this->parameterBag->get('ADMIN_USER_EMAIL'),
                'password' => $this->parameterBag->get('ADMIN_USER_PASS'),
                'roles' => ['ROLE_ADMIN']
            ],
        ];
        $int = 1;
        foreach ($users as $val) {
            $user = new User();
            $user->setPseudo($val['pseudo']);
            $user->setFirstName($val['first_name']);
            $user->setLastName($val['last_name']);
            $user->setEmail($val['email']);
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, $val['password']));
            $user->setRoles($val['roles']);
            $manager->persist($user);
            $this->addReference('user_' . $int, $user);
            $int += 1;
        }
        $manager->flush();
    }
}

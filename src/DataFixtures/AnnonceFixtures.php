<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Service\Slugify;
use Container2nH1tOz\getCategoryRepositoryService;
use Container2nH1tOz\getUserRepositoryService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AnnonceFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var Slugify
     */
    private Slugify $slugify;

    private CategoryRepository $categoryRepository;
    private UserRepository $userRepository;

    public const VEHICULEDETAILS = ([
        'signe_1' => false,
        'sign_2' => false,
        'signe_3' => false,
        'signe_4' => false
    ]);

    public const VEHICULES = [  'Mercedes GLA',
        'Mini-pelle Kubota',
        'Moissoneuse batteuse Claas',
        'Mini-pelle Yanmar',
        'Tracteur John Deere',
        'Machine à vendanger New Holland',
        '205 Alpine de collection',
        'Tracteur Lamborghini',
        'Machine à vendanger Fendt',
        'Ferrari F40',
        'Mini-pelle Komatsu',
        'Tracteur New Holland',
    ];
    /**
     * AnnonceFixtures constructor.
     * @param Slugify $slugify
     * @param CategoryRepository $categoryRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        Slugify $slugify,
        CategoryRepository $categoryRepository,
        UserRepository $userRepository
    ) {
        $this->slugify = $slugify;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
    }


    public function load(ObjectManager $manager)
    {
        $slugify = new Slugify();

        $faker = Factory::create();
        //generate data

        foreach (self::VEHICULES as $key => $vehicules) {
            $annonce = new Annonce();
            $annonce->setTitle($vehicules);
            $annonce->setDescription($faker->text());
            $annonce->setPublishedAt($faker->dateTime());
            $annonce->setEndPublishedAt($faker->dateTime());
            $annonce->setStolenAt($faker->dateTime());
            $annonce->setStatus(1);
            $annonce->setReference($faker->randomLetter() . $faker->randomLetter() .
                $faker->numberBetween(000, 999) . $faker->randomLetter() . $faker->randomLetter());
            $annonce->setLocation($faker->numberBetween(10000, 99999));
            $annonce->setDetails(self::VEHICULEDETAILS);

            //Relations fixtures
            // switch($annonce){
            //     case strstr($annonce->getTitle(),'pelle'):
            //         $annonce->setCategory($this->categoryRepository->findOneByName('BTP'));
            //         break;
            //     case strstr($annonce->getTitle(),'tracteur'):
            //         $annonce->setCategory($this->categoryRepository->findOneByName('Agroalimentaire'));
            //         break;
            //     case strstr($annonce->getTitle(),'moissonneuse'):
            //         $annonce->setCategory($this->categoryRepository->findOneByName('moissoneuse_bateuse'));
            // }
            $annonce->setCategory($this->getReference('category_' . rand(0, 5)));
            $annonce->setOwner($this->userRepository->findOneByRole(rand(1, 3)));
            $annonce->setSlug($slugify->generate($annonce->getTitle()));

            $manager->persist($annonce);
            $this->addReference('annonce_' . $key, $annonce);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}

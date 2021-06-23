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
        'peinture' => 'rouge',
        'date_achat' => '2019',
        'defaults' => 'rayures aile gauche'
    ]);

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
            $annonce->setDetails(self::VEHICULEDETAILS);

            //Relations fixtures
            $annonce->setCategory($this->categoryRepository->findOneByName('BTP'));
            $annonce->setOwner($this->userRepository->findOneByRole(rand(1, 3)));
            $annonce->setSlug($slugify->generate($annonce->getTitle()));

            $manager->persist($annonce);
            $this->addReference('annonce_' . $i, $annonce);
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

<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture implements FixtureGroupInterface
{
    public const CATEGORIES = [
        [
            'name' => 'BTP',
            'children' => [
                [
                    'name' => 'Pelle'
                ],
                [
                    'name' => 'Grue'
                ],
                [
                    'name' => 'Camion',
                    'children' => [
                        [
                            'name' => '3.5 t'
                        ],
                        [
                            'name' => '15 t'
                        ],
                        [
                            'name' => '35 t'
                        ],
                    ]
                ]
            ]
        ],
        [
            'name' => 'Particuliers',
            'children' => [
                [
                    'name' => 'Voiture'
                ],
                [
                    'name' => 'Moto'
                ],
                [
                    'name' => 'Scooter'
                ],
                [
                    'name' => 'Vélo'
                ],
            ]
        ],
        [
            'name' => 'Mer',
            'children' => [
                [
                    'name' => 'Bateau à moteur'
                ],
                [
                    'name' => 'Voilier'
                ],
                [
                    'name' => 'Scooter des mers'
                ],
                [
                    'name' => 'Char à voile'
                ],
            ]
        ]
    ];


    public function load(ObjectManager $manager)
    {
        // Génération des catégories mères
        $categoryIndex = 0;
        foreach (self::CATEGORIES as $val) {
            $categoryIndex++;
            $category = new Category();
            $category->setName($val['name']);
            $manager->persist($category);
            $this->addReference('category_' . $categoryIndex, $category);
            if (isset($val['children'])) {
                $this->loadChildren($category, $val['children'], $manager, $categoryIndex);
            }
        }
        $manager->flush();
    }

    private function loadChildren($category, $children, $manager, &$categoryIndex)
    {

        foreach ($children as $child) {
            $categoryIndex++;
            $categoryChild = new Category();
            $categoryChild->setName($child['name']);
            $categoryChild->setCategory($category);
            $manager->persist($categoryChild);
            $this->addReference('category_' . $categoryIndex, $categoryChild);
            if (isset($child['children'])) {
                $this->loadChildren($categoryChild, $child['children'], $manager, $categoryIndex);
            }
        }
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }
}

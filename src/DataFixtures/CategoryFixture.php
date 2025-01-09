<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $now = new \DateTime();

        for ($enum = 0; $enum < 10; $enum++) {
            $category = new Category();
            $category->setName('Category ' . $enum);
            $category->setDescription('Description ' . $enum);
            $category->setCreatedAt($now);
            $category->setUpdatedAt($now);

            $manager->persist($category);
            $this->addReference('category_' . $enum, $category);
        }

        $manager->flush();
    }
}
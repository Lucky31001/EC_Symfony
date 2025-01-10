<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $now = new \DateTime();

        for ($enum = 0; $enum < 10; ++$enum) {
            $category = new Category();
            $category->setName('Category '.$enum);
            $category->setDescription('Description '.$enum);
            $category->setCreatedAt($now);
            $category->setUpdatedAt($now);

            $manager->persist($category);
            $this->addReference('category_'.$enum, $category);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
        ];
    }
}

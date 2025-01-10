<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $now = new \DateTime();

        for ($enum = 0; $enum < 10; ++$enum) {
            $book = new Book();
            $book->addCategory($this->getReference('category_'.rand(0, 9), Category::class));
            $book->setName('Book '.$enum);
            $book->setDescription('Description '.$enum);
            $book->setPages(rand(100, 500));
            $book->setPublicationDate(new \DateTime());
            $book->setCreatedAt($now);
            $book->setUpdatedAt($now);

            $this->addReference('book_'.$enum, $book);
            $manager->persist($book);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixture::class,
            UserFixture::class,
        ];
    }
}

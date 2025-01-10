<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\BookRead;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookReadFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $now = new \DateTime();

        for ($enum = 0; $enum < 10; ++$enum) {
            $bookread = new BookRead();
            $bookread->setBook($this->getReference('book_'.$enum, Book::class));
            $bookread->setUser($this->getReference('user_1', User::class));
            $bookread->setRating(rand(0, 5));
            $bookread->setDescription('Description de lecture');
            $bookread->setRead(rand(0, 1));
            $bookread->setCreatedAt($now);
            $bookread->setUpdatedAt($now);

            $manager->persist($bookread);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BookFixture::class,
            UserFixture::class,
        ];
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $now = new \DateTime();

        $user = new User();
        $user->setEmail('test@test.test');
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'Azerty123'));

        $user2 = new User();
        $user2->setEmail('test2@test.test');
        $user2->setPassword($this->userPasswordHasher->hashPassword($user, 'Azerty123'));

        $manager->persist($user2);
        $manager->persist($user);
        $this->addReference('user_0', $user);
        $this->addReference('user_1', $user2);

        $manager->flush();
    }
}

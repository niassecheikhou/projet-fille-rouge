<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $users = new User();
        // $users->setNomComplet('OUSMAN');
        // $hacherpassword=$this->passwordHasher->hashPassword($users,"mdp");
        // $users->setPassword($hacherpassword);
        // $users ->setLogin('niass@gmail.com');
        // $users ->setEtat(1);
        // $users->setRoles(['ROLE_CLIENT']);

        // $manager->persist($users);
        // $manager->flush();
    }
}

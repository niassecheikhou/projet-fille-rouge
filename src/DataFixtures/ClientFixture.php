<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixture extends Fixture
{
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager ): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $client = new Client;
 
        $client->setNomComplet('Dame');
         $hacherpassword=$this->passwordHasher->hashPassword($client,"mdp");
        $client->setPassword($hacherpassword);
        $client ->setLogin('azerty@gmail.com');
        $client ->setEtat(1);
        $client->setAdresse('Touba');
        $client->setRoles(['ROLE_CLIENT']);

        $client->setTelephone('777654480');

    
        $manager->persist($client);
        $manager->flush(); 
    }
}

<?php

namespace App\DataPersister;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserDataPersister implements DataPersisterInterface
{
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;
    private ?TokenInterface $token;
    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->passwordHasher= $passwordHasher;
        $this->entityManager = $entityManager;
        $this->token = $tokenStorage->getToken();
    }

    
    public function supports($data): bool
    {
        return $data instanceof User;
    }


    /**
    * @param User $data
    */
    public function persist($data)
    {
        $hashedPassword = $this->passwordHasher->hashPassword($data, $data->getPassword());
        $data->setPassword($hashedPassword);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
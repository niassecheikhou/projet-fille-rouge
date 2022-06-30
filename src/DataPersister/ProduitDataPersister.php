<?php

namespace App\DataPersister;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProduitDataPersister implements DataPersisterInterface
{
    
    private ?TokenInterface $token;

    public function __construct(
        TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager
     )

    {
       $this->entityManager=$entityManager;
        $this->token = $tokenStorage->getToken();
    }

    
    public function supports($data): bool
    {
        return $data instanceof Produit ;
    }

    public function getUser()
    {   
     return $this->token->getUser() ;
    }
        
    
    
    /**
    * @param Produit $data
    */
    public function persist($data)
    {
      
        $data->setGestionnaire($this->getUser());
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
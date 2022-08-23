<?php

namespace App\DataPersister;

use App\Entity\Livraison;
use App\Repository\LivreurRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\GestionnaireRepository;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


     class  LivraisonDataPersister implements DataPersisterInterface
    {
   
    
    private ?TokenInterface $token;
    private $entityManager;
    

    public function __construct(
        
        EntityManagerInterface $entityManager,
        LivreurRepository $livreur,
        CommandeRepository $commande,
        TokenStorageInterface $token,
     )
     
    {
        $this->entityManager=$entityManager;
        $this ->livreur = $livreur;
        $this-> commande = $commande;
        $this->token = $token->getToken();
    }

    
    public function supports($data ,array $context=[]): bool
    {
        return $data instanceof Livraison ;
    }
    
    
    /**
     * @param Livraison $data
     */
    public function persist($data,array $context=[])
    {
        $commandes = ($data->getCommandes());
        // dd($commandes);
        
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }


    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}

// src/DataPersister/DataPersister.php
/*
namespace App\DataPersister;

use LDAP\Result;
use App\Entity\User;
use App\Entity\Livreur;
use App\Entity\Livraison;
use App\Services\MailerService;
use App\Repository\LivreurRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\DataFixtures\GestionnaireFixtures;
use App\Repository\GestionnaireRepository;
use Namshi\JOSE\JWS;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\Json;


class LivraisonDataPersister implements ContextAwareDataPersisterInterface
{
    private $entityManager;
    private ?TokenInterface $token;


    public function __construct(
        EntityManagerInterface $entityManager,
        LivreurRepository $livreurR,
        CommandeRepository $cmdeR,
        private GestionnaireRepository $gestionnaireRepository,
        TokenStorageInterface $token
    ){
        $this->entityManager = $entityManager;
        $this->livreurR=$livreurR;
        $this->cmdeR=$cmdeR;
        $this->token=$token->getToken();
    }

   
     * {@inheritdoc}
    
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Livraison;
    }

    
     * @param Livraison $data
    
    public function persist($data, array $context = [])
    {    
        // l'enssemble des commande qui exixte dans la livraison
        $cmdes=$data->getCommandes();
        // dd($cmdes);
        foreach($cmdes as $cmde){
            if ($cmde->getEtat()!="terminer"){   //Pour chaque cmde est en cours ou terminer;
                return new JsonResponse(["message"=>"La commande de reference".$cmde->getReference()." n'est pas encore terminé !!"],Response::HTTP_BAD_REQUEST);
            }
        }
        // selectionné les livreur dont Etat=1 et est disponible (disponnible)
        $livreurs=$this->livreurR->findBy([
            "is_disponible" => true,
            "etat" => 1,
        ]);
        if (empty($livreurs)) {
            return  new JsonResponse(["message" => "Pas de Livreur disponible!!"],Response::HTTP_BAD_REQUEST);
        }
        
        // $livreurDispoCmde= $livreurs[array_rand($livreurs)];

        if(!in_array($data->getLivreur(),$livreurs)){
            return  new JsonResponse(["message" => "ce Livreur est indisponible!!"],Response::HTTP_BAD_REQUEST);

        }
        $livreurDispoCmde=$data->getLivreur();
        $data->setLivreur($livreurDispoCmde);
        foreach ($cmdes as $cmde) {
            $cmde->setEtat("enCoursDeLivraison");
            $this->entityManager->persist($cmde);
        }
        $this->entityManager->persist($data);
        $livreurDispoCmde->setEtat(0);
        $livreurDispoCmde->setIsDisponible(0);
        
        $data->setGestionnaire($this->gestionnaireRepository->find(2));
        // $data->setGestionnaire($this->token->getUser());
        $this->entityManager->persist($livreurDispoCmde);
        $this->entityManager->flush();
    }

    
     * {@inheritdoc}
     
    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
    
}
*/
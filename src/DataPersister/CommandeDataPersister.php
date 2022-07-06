<?php

namespace App\DataPersister;


use App\Entity\Commande;
use App\Entity\LigneCommande;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class CommandeDataPersister implements DataPersisterInterface
{

    public function __construct(EntityManagerInterface $em){
        $this->em=$em;
    }
    public function supports($data): bool
    {
        return $data instanceof Commande   ;
    }

    
    
    /**
    * @param Commande $data
    */
    public function persist($data)
    {
        $lignecommades = ( $data->getLigneDecommandes());
        
        foreach ($lignecommades as $lignecommade){
          $Q= $lignecommade->getQantiteCommander();
           $Pu=$lignecommade->getProduit()->getPrix();
           $montantPayer=($Q*$Pu);
           
           $lignecommade->setMontantPayer($montantPayer);
        }
       
        
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}
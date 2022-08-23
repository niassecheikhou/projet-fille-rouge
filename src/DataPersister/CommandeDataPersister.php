<?php

namespace App\DataPersister;


use Date;
use App\Entity\Boisson;
use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CommandeDataPersister implements DataPersisterInterface
{
    private $entityManager;
    // private ?TokenInterface $token;
    private ClientRepository $repoClient;

    public function __construct(EntityManagerInterface $em,ClientRepository $repoClient){
        $this->em=$em;
        $this->repoClient=$repoClient;
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
        // dd($data);
        $prixTotal = 0;

        foreach ($lignecommades as $lignecommade){

            // $produit = $lignecommade->getProduit();
            // if ($produit InstanceOf Boisson) {
            //     $tailles = $produit->getTailleBoisson();
            //     foreach ($tailles as $tailles){
            //         $stock = $tailles->getStock();
            //         $taille->setStock($stock - ($lignecommade->getQantiteCommander()));
            //     }
                
            // }
            $Q = $lignecommade->getQantiteCommander();
           $Pu=$lignecommade->getProduit()->getPrix();
           //    $p = $lignecommade ->getCommande()->getPrixTotal();
           //    dd($p);
           $montantPayer=($Q*$Pu);
           $lignecommade->setMontantPayer($montantPayer);
           
           $prixTotal += $lignecommade->getMontantPayer();
        }
        
        // dd($numComm);
        $data->setCreateAt((new \DateTimeImmutable()));
        // dd($prixTotal);
         $data->setPrixTotal($prixTotal);
        // dd($data);
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}
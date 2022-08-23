<?php

namespace App\Entity;

use App\Entity\Produit;
use App\Entity\Commande;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LigneCommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LigneCommandeRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            'method' => 'get',
            'normalization_context' => ['groups' => ['lignedecommande:red:simple']],
            ]
    
         ,"post"=>[
                'denormalization_context' => ['groups' => ['lignedecommande:write:simple']],
                 ],
],
itemOperations:["put","get"]
)]
class LigneCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['commande:write:simple','commande:red:simple','lignedecommande:red:simple'])]
    private $id;

    #[ORM\Column(type: 'integer',nullable:true)]
    #[Groups(['commande:red:simple','commande:write:simple','livraison:red:simple','lignedecommande:write:simple','lignedecommande:red:simple'])]
    private $qantiteCommander;

    #[ORM\Column(type: 'integer')]
    #[Groups(['commande:red:simple','livraison:red:simple','lignedecommande:write:simple','lignedecommande:red:simple'])]
    private $montantPayer;

    #[ORM\ManyToOne( targetEntity: Commande::class, inversedBy: 'ligneDeCommandes')]
    // #[Groups(['commande:write:simple','commande:red:simple'])]
    private $commande;


    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'ligneDecommandes')]
    #[Groups(['commande:write:simple','commande:red:simple','commande:red:items','lignedecommande:write:simple','lignedecommande:red:simple'])]
    private $produit;


    public function __construct()
    {

    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQantiteCommander(): ?int
    {
        return $this->qantiteCommander;
    }

    public function setQantiteCommander(int $qantiteCommander): self
    {
        $this->qantiteCommander = $qantiteCommander;

        return $this;
    }

    public function getMontantPayer(): ?int
    {
        return $this->montantPayer;
    }

    public function setMontantPayer(int $montantPayer): self
    {
        $this->montantPayer = $montantPayer;

        return $this;
    }


    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

   

}



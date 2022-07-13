<?php

namespace App\Entity;

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
    
    ,"post"],
itemOperations:["put","get"]
)]
class LigneCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['commande:red:simple','lignedecommande:red:simple'])]
    private $qantiteCommander;

    #[ORM\Column(type: 'integer')]
    #[Groups(['commande:red:simple','ligne de commande:red:simple'])]
    private $montantPayer;

    #[Groups(['lignedecommande:red:simple'])]
    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'ligneDecommandes')]
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
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


  

    #[Groups(['commande:red:simple'])]

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addLigneDecommande($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeLigneDecommande($this);
        }

        return $this;
    }
}
  // /**
    //  * @return Collection<int, Commande>
    //  */
    // public function getCommande(): Collection
    // {
    //     return $this->commande;
    // }


    // public function getCommande(): ?Commande
    // {
    //     return $this->commandes;
    // }

    // public function setCommande(?Commande $commande): self
    // {
    //     $this->commande = $commande;

    //     return $this;
    // }

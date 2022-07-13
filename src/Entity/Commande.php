<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            'method' => 'get',
            'normalization_context' => ['groups' => ['commande:red:simple']],
            ]
    
    ,"post"=>[
    'denormalization_context' => ['groups' => ['commande:red:simple']],

    ]
],
itemOperations:["put","get"]
)]

class Commande
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer',nullable:true)]
    // #[Groups(['commande:red:simple'])]
    private $numeroCommande;

    #[ORM\Column(type: 'string', length: 255,nullable:true)]
    // #[Groups(['commande:red:simple'])]
    private $dateCommande;



    // #[ORM\ManyToMany(targetEntity: LigneCommande::class, inversedBy: 'commandes')]

    // private $commandes;

    // #[ORM\ManyToMany(targetEntity: Produit::class, mappedBy: 'commandes')]
    // private $produits;
    // pour changer le ligneCommande en Produits on utilise  #[SerializedName('Produits')]
    // #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneCommande::class,cascade:['persist'])]
    // private $ligneDecommande;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    private $client;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

    #[SerializedName('Produits')]
    #[ORM\ManyToMany(targetEntity: LigneCommande::class, inversedBy: 'commandes',cascade:['persist'])]
    #[Groups(['commande:red:simple'])]
    private $ligneDecommandes;

    // #[ORM\ManyToMany(targetEntity: LigneCommande::class, inversedBy: 'commandes')]
    // private $ligneDeCommandes;



    public function __construct()
    {

        // $this->produits = new ArrayCollection();
        // $this->ligneDeCommandes = new ArrayCollection();
        // $this->ligneDecommande = new ArrayCollection();
        $this->ligneDecommandes = new ArrayCollection();
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCommande(): ?int
    {
        return $this->numeroCommande;
    }

    public function setNumeroCommande(int $numeroCommande): self
    {
        $this->numeroCommande = $numeroCommande;

        return $this;
    }

    public function getDateCommande(): ?string
    {
        return $this->dateCommande;
    }

    public function setDateCommande(string $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    // /**
    //  * @return Collection<int, LigneCommande>
    //  */
    // public function getLigneDecommande(): Collection
    // {
    //     return $this->ligneDecommande;
    // }

    // public function addLigneDecommande(LigneCommande $ligneDecommande): self
    // {
    //     if (!$this->ligneDecommande->contains($ligneDecommande)) {
    //         $this->ligneDecommande[] = $ligneDecommande;
    //         $ligneDecommande->setCommande($this);
    //     }

    //     return $this;
    // }

    // public function removeLigneDecommande(LigneCommande $ligneDecommande): self
    // {
    //     if ($this->ligneDecommande->removeElement($ligneDecommande)) {
    //         // set the owning side to null (unless already changed)
    //         if ($ligneDecommande->getCommande() === $this) {
    //             $ligneDecommande->setCommande(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneDecommandes(): Collection
    {
        return $this->ligneDecommandes;
    }

    public function addLigneDecommande(LigneCommande $ligneDecommande): self
    {
        if (!$this->ligneDecommandes->contains($ligneDecommande)) {
            $this->ligneDecommandes[] = $ligneDecommande;
        }

        return $this;
    }

    public function removeLigneDecommande(LigneCommande $ligneDecommande): self
    {
        $this->ligneDecommandes->removeElement($ligneDecommande);

        return $this;
    }
}

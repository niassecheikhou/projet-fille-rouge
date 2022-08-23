<?php

namespace App\Entity;

use App\Entity\Client;
use App\Entity\Livraison;
use App\Entity\LigneCommande;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations:[
     "get"=>[
            'normalization_context' => ['groups' => ['commande:red:simple']],
            ]
    
    ,"post"=>[
    'denormalization_context' => ['groups' => ['commande:write:simple']],

    ]
],
itemOperations:[
    "put",
    "get"=>['normalization_context' => ['groups' => ['commande:red:items']]]
]
)]

class Commande
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['commande:red:simple','commande:write:simple','commande:red:items'])]
    private $id;

    #[ORM\Column(type: 'integer',nullable:true)]
    #[Groups(['commande:red:simple','commande:write:simple','commande:red:items','livraison:red:simple','zone:red:simple','client:red:items'])]
    private $numeroCommande;

    // #[ORM\Column(type: 'date', length: 255,nullable:true)]
    // #[Groups(['commande:red:simple','commande:write:simple','commande:red:items','livraison:red:simple','zone:red:simple'])]
    // private $dateCommande;
    
    
    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
     #[Groups(['commande:red:simple','commande:write:simple','commande:red:items','livraison:red:simple','zone:red:simple'])]
    private $client;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    #[Groups(['commande:red:simple','commande:write:simple','commande:red:items'])]
    private $livraison;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneCommande::class,cascade: ['persist'])]
     #[Groups(['commande:red:simple','commande:write:simple','commande:red:items','livraison:red:simple'])]
     #[SerializedName('Produits')]
    private $ligneDeCommandes;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[Groups(['commande:write:simple'])]
    private ?Gestionnaire $gestionnaire = null;

    #[ORM\Column]
    #[Groups(['commande:red:simple','commande:red:items','zone:red:simple','client:red:items'])]
    private ?int $prixTotal = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Zone $zone = null;
    
    #[ORM\Column]
    #[Groups(['commande:red:simple'])]
    private ?\DateTimeImmutable $createAt = null;

   

    // #[SerializedName('Produits')]
    // #[ORM\ManyToMany(targetEntity: LigneCommande::class, inversedBy: 'commandes',cascade:['persist'])]
    // #[Groups(['commande:red:simple'])]
    // private $ligneDecommandes;





    public function __construct()
    {

        // $this->produits = new ArrayCollection();
        // $this->ligneDecommandes = new ArrayCollection();
        $this->ligneDeCommandes = new ArrayCollection();
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCommande()
    {
        return $this->numeroCommande;
    }

    public function setNumeroCommande(int $numeroCommande): self
    {
        $this->numeroCommande = $numeroCommande;

        return $this;
    }

    // public function getDateCommande()
    // {
    //     return $this->dateCommande;
    // }

    // public function setDateCommande($dateCommande): self
    // {
    //     $this->dateCommande = $dateCommande;

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

    // /**
    //  * @return Collection<int, LigneCommande>
    //  */
    // public function getLigneDecommandes(): Collection
    // {
    //     return $this->ligneDecommandes;
    // }

    // public function addLigneDecommande(LigneCommande $ligneDecommande): self
    // {
    //     if (!$this->ligneDecommandes->contains($ligneDecommande)) {
    //         $this->ligneDecommandes[] = $ligneDecommande;
    //     }

    //     return $this;
    // }

    // public function removeLigneDecommande(LigneCommande $ligneDecommande): self
    // {
    //     $this->ligneDecommandes->removeElement($ligneDecommande);

    //     return $this;
    // }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneDeCommandes(): Collection
    {
        return $this->ligneDeCommandes;
    }

    public function addLigneDeCommande(LigneCommande $ligneDeCommande): self
    {
        if (!$this->ligneDeCommandes->contains($ligneDeCommande)) {
            $this->ligneDeCommandes[] = $ligneDeCommande;
            $ligneDeCommande->setCommande($this);
        }

        return $this;
    }

    public function removeLigneDeCommande(LigneCommande $ligneDeCommande): self
    {
        if ($this->ligneDeCommandes->removeElement($ligneDeCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneDeCommande->getCommande() === $this) {
                $ligneDeCommande->setCommande(null);
            }
        }

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    public function getPrixTotal(): ?int
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(int $prixTotal): self
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

}

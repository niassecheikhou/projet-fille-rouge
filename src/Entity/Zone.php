<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            'method' => 'get',
            'normalization_context' => ['groups' => ['zone:red:simple']],
        ],
        "post"=>['denormalization_context' => ['groups' => ['zone:whrite:simple']]],
    ],   
itemOperations:[
    "get" => ['normalization_context' => ['groups' => ['zone:red:simple']]]
]
)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['zone:red:simple','livraison:red:simple','zone:whrite:simple'])]
    private $id;

    // #[Groups(['groups' => 'menu:red:simple'])]
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['zone:red:simple','livraison:red:simple','zone:whrite:simple','commande:red:items'])]
    private $nomZone;

    #[ORM\Column(type: 'integer')]
    #[Groups(['zone:red:simple','livraison:red:simple','zone:whrite:simple','commande:red:items'])]
    private $coutZone;

    #[ORM\Column(type: 'boolean')]
    private $isetat=true;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Livraison::class)]
    #[Groups(['zone:whrite:simple'])]
    private $livraisons;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Commande::class)]
    #[Groups(['zone:red:simple'])]
    private Collection $commandes;

    

    public function __construct()
    {
        $this->livraisons = new ArrayCollection();
        $this->y = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomZone(): ?string
    {
        return $this->nomZone;
    }

    public function setNomZone(string $nomZone): self
    {
        $this->nomZone = $nomZone;

        return $this;
    }

    public function getCoutZone(): ?int
    {
        return $this->coutZone;
    }

    public function setCoutZone(int $coutZone): self
    {
        $this->coutZone = $coutZone;

        return $this;
    }

    public function isIsetat(): ?bool
    {
        return $this->isetat;
    }

    public function setIsetat(bool $isetat): self
    {
        $this->isetat = $isetat;

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setZone($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getZone() === $this) {
                $livraison->setZone(null);
            }
        }

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
            $commande->setZone($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getZone() === $this) {
                $commande->setZone(null);
            }
        }

        return $this;
    }

    
    
  
}

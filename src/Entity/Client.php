<?php

namespace App\Entity;
 
use App\Entity\User;
use App\Entity\Commande;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            'method' => 'get',
            'normalization_context' => ['groups' => ['client:red:simple']],
            ]
    
    ,"post"],
itemOperations:["put",
    "get"=>['normalization_context' => ['groups' => ['client:red:items']]],
]
)]

class Client  extends User
{
    
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['client:red:simple','commande:red:items','livraison:red:simple','zone:red:simple','client:red:items'])]
    private $adresse;

    #[Groups(['client:red:simple','commande:red:simple','commande:red:items','livraison:red:simple','zone:red:simple','client:red:items'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $telephone;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    #[Groups(['client:red:simple','client:red:items'])]           
    private $commandes;

    public function __construct()
    {
        parent::__construct();
        $this->commandes = new ArrayCollection();
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

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
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

    
}

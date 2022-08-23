<?php

namespace App\Entity;

use App\Entity\Gestionnaire;
use App\Entity\LigneCommande;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\OpenApi\Model\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type", type:"string")]
#[ORM\DiscriminatorMap(["complement"=>"Complement", "burger"=>"Burger","boisson"=>"Boisson","fritte"=>"Fritte","menu"=>"Menu"])]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ApiResource(
        collectionOperations: [ 
         'get' => [
            "normalization_context"=>['groups' => ['produits :red:simple']]
         ],
         
        ]
)]



class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
    'burger:red:simple','menu',
    'catalogues:red:simple',
    'boisson:red:simple','menu:red:complete', 'menu:red:complet','commande:red:simple'])]
    protected $id;

    // #[Groups(['lignedecommande:red:simple'])]
    #[ORM\Column(type: 'blob' ,nullable: true)]
    #[Groups(['burger:red:write',
    'burger:red:simple',
    'catalogues:red:simple',
    'boisson:red:simple',
    'menu:red:complete',
    'commande:red:simple','lignedecommande:red:simple'])]
    protected $image;

    #[ORM\Column(type: 'string', length: 255)]
    // #[Groups(['ligne de commande:red:simple'])]
    #[Groups(['burger:red:write',
    'burger:red:simple',
    'menu:write:simple',
    'catalogues:red:simple',
    'boisson:red:simple', 
    'menu:red:complet',
    'commande:red:simple',
    'commande:red:items',
    'fritte:write',
    'fritte:red:simple','lignedecommande:red:simple'])]
      protected $nomProduit;

    #[ORM\Column(type: 'string', length: 255 ,nullable: true)]
    #[Groups(['burger:red:write',
    'burger:red:simple',
    'menu:write:simple',
    'catalogues:red:simple','fritte:write','lignedecommande:red:simple'])]
    protected $description;

    #[ORM\Column(type: 'integer',nullable:true)]
    #[Groups(['burger:red:write',
    'burger:red:simple',
    'menu:write:simple','catalogues:red:simple'
    ,'boisson:red:simple','commande:red:simple','commande:red:items','fritte:write','lignedecommande:red:simple'])]
    protected $prix;


    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    private $gestionnaire;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['commande:red:simple'])]
    private $isEtat=true;

    // #[ORM\Column(length: 255)]
    #[Groups(['burger:red:write','burger:red:simple','fritte:write'])]
    #[SerializedName('image')]
    private ?string $photo = null;


    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneCommande::class)]
    // #[Groups(['commande:red:items'])]
    private $ligneDecommandes;
    
    #[ORM\Column]
    #[Groups(['burger:red:write','burger:red:simple','fritte:write','commande:red:simple'])]
    private ?\DateTimeImmutable $createAt = null;




    public function __construct()
    {
        // $this->produits = new ArrayCollection();
        //$this->commandes = new ArrayCollection();
        $this->ligneDecommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
    return (is_resource($this->image) ? utf8_encode(base64_encode (stream_get_contents($this->image))):$this->image);
    }    

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }


    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(string $nomProduit): self
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

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

    public function isIsEtat(): ?bool
    {
        return $this->isEtat;
    }

    public function setIsEtat(bool $isEtat): self
    {
        $this->isEtat = $isEtat;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

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
            $ligneDecommande->setProduit($this);
        }

        return $this;
    }

    public function removeLigneDecommande(LigneCommande $ligneDecommande): self
    {
        if ($this->ligneDecommandes->removeElement($ligneDecommande)) {
            if ($ligneDecommande->getProduit() === $this) {
                $ligneDecommande->setProduit(null);
            }
        }

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

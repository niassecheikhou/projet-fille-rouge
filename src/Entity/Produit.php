<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type", type:"string")]
#[ORM\DiscriminatorMap(["complement"=>"Complement", "burger"=>"Burger","boisson"=>"Boisson","fritte"=>"Fritte","menu"=>"Menu"])]

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ApiResource()]
//     collectionOperations: [ 
//         'get', 'post' => [
//              'input_formats' =>  [ 'multipart' => ['multipart/form-data']]
// )]

class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    // #[Groups(['lignedecommande:red:simple'])]
    #[ORM\Column(type: 'string', length: 255 ,nullable: true)]
    protected $image;

    #[ORM\Column(type: 'string', length: 255)]
    // #[Groups(['ligne de commande:red:simple'])]
      protected $nomProduit;

    #[ORM\Column(type: 'string', length: 255 ,nullable: true)]
    protected $description;

    #[ORM\Column(type: 'integer', length: 255,nullable:true)]
    protected $prix;


    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    private $gestionnaire;

    #[ORM\Column(type: 'boolean')]
    private $isEtat=true;



    public function __construct()
    {
        // $this->produits = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
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

}

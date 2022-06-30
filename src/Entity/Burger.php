<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            'method' => 'get',
            'normalization_context' => ['groups' => ['burger:red:simple']],
            ]
    
    ,"post"],
itemOperations:["put","get"]
)]
class Burger extends Produit
{
    #[Groups(["burger:red:simple"])]

    #[ORM\Column(type: 'string', length: 255)]
    private $categorie;


    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

   
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FritteRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: FritteRepository::class)]
#[ApiResource]

class Fritte extends Complement
{
    #[ORM\Column(type: 'string', length: 255,nullable:true)]
    private $quantite;

   
    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(string $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    
}

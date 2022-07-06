<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FritteRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: FritteRepository::class)]
#[ApiResource]

class Fritte extends Produit
{
    #[ORM\Column(type: 'string', length: 255,nullable:true)]
    private $quantite;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'frittes')]
    private $menus;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
    }

   
    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(string $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addFritte($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeFritte($this);
        }

        return $this;
    }

    
}

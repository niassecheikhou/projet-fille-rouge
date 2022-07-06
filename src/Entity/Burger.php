<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["burger:red:simple"])]
    private $categorie;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'burgers')]
    #[Groups(["burger:red:simple"])]
     private $menus;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
    }


    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

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
            $menu->addBurger($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeBurger($this);
        }

        return $this;
    }

   
}

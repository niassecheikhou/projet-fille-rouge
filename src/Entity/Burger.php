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
    collectionOperations: [
        "get" => [
            'method' => 'get',
            'normalization_context' => ['groups' => ['burger:red:simple']],
        ], "post" => [
            'denormalization_context' => ['groups' => ['burger:red:write']]
        ]
    ],
    itemOperations: ["put", "get"]
)]
class Burger extends Produit
{

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(
        [
            "burger:red:simple",
            'catalogues:red:simple',
            'burger:red:write'
        ]
    )]


    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: MenuBurger::class)]
    // #[Groups(['menu:red:simple'])]
    private $menuBurgers;



    public function __construct()
    {
        parent::__construct();
        $this->menuBurgers = new ArrayCollection();
    }



    /**
     * @return Collection<int, MenuBurger>
     */
    // public function getMenuBurgers(): Collection
    // {
    //     return $this->menuBurgers;
    // }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setBurger($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getBurger() === $this) {
                $menuBurger->setBurger(null);
            }
        }

        return $this;
    }
}


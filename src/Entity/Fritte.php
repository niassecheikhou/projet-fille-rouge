<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FritteRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FritteRepository::class)]
#[ApiResource(
     collectionOperations :[
        "get" => [
            'normalization_context' => ['groups' => ['fritte:red:simple']],
        ], "post" => [
            'denormalization_context' => ['groups' => ['fritte:write']]
        ]
    ]
)]

class Fritte extends Produit
{
    #[ORM\Column(type: 'string', length: 255,nullable:true)]
    #[Groups(['fritte:write','fritte:red:simple'])]
    private $quantite;

    #[Groups(['complement:red:simple'])]
    #[ORM\OneToMany(mappedBy: 'fritte', targetEntity: MenuFritte::class)]
    private $menuFrittes;

    public function __construct()
    {
        parent::__construct();
        $this->menuFrittes = new ArrayCollection();
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
     * @return Collection<int, MenuFritte>
     */
    public function getMenuFrittes(): Collection
    {
        return $this->menuFrittes;
    }

    public function addMenuFritte(MenuFritte $menuFritte): self
    {
        if (!$this->menuFrittes->contains($menuFritte)) {
            $this->menuFrittes[] = $menuFritte;
            $menuFritte->setFritte($this);
        }

        return $this;
    }

    public function removeMenuFritte(MenuFritte $menuFritte): self
    {
        if ($this->menuFrittes->removeElement($menuFritte)) {
            // set the owning side to null (unless already changed)
            if ($menuFritte->getFritte() === $this) {
                $menuFritte->setFritte(null);
            }
        }

        return $this;
    }

   
    
}

    // #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'frittes')]
    // private $menus;

    // public function __construct()
    // {
    //     $this->menus = new ArrayCollection();
    // }
 // /**
    //  * @return Collection<int, Menu>
    //  */
    // public function getMenus(): Collection
    // {
    //     return $this->menus;
    // }

    // public function addMenu(Menu $menu): self
    // {
    //     if (!$this->menus->contains($menu)) {
    //         $this->menus[] = $menu;
    //         $menu->addFritte($this);
    //     }

    //     return $this;
    // }

    // public function removeMenu(Menu $menu): self
    // {
    //     if ($this->menus->removeElement($menu)) {
    //         $menu->removeFritte($this);
    //     }

    //     return $this;
    // }

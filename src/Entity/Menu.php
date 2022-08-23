<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\MenuController;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    collectionOperations: [

        // 'ajouterMenu' => [
        //     'method' => 'POST',
        //     'path' => '/menus2',
        //     'controller' => MenuController::class,
        //     'deserialize' => false,
        //     'normalization_context' => ['groups' => ['menu']],

        // ],
        "post" => [
            // 'denormalization_context' => ['groups' => ['menu:write:simple']],
            "denormalization_context"=>['groups' => ['menu:red:simple']]

        ],
        "get" => [
            "status"=> Response::HTTP_OK,
            "normalization_context"=>['groups' => ['menu:red:complet']],
        ]
    ],
    itemOperations: ["get" => [
        "status"=> Response::HTTP_OK,
        "normalization_context"=>['groups' => ['menu:red:complete']],
    ], 'put']
)]
class Menu extends Produit
{
    #[Groups(['menu:red:complet','catalogues:red:simple','menu:red:simple'])]
    protected $id;

    #[Groups(['menu:red:complet','catalogues:red:simple','menu:red:simple'])]
    protected $quantite;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class, cascade: ['persist'])]
    #[Groups(['menu:red:complet','catalogues:red:simple','menu:red:simple'])]
    #[SerializedName('burgers')]
    private $menuBurgers;

    #[Groups(['menu:red:complet','catalogues:red:simple','menu:red:simple'])]
    protected $image;

    #[Groups(['menu:red:complet','catalogues:red:simple','menu:red:simple'])]
    protected $nomProduit;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuFritte::class, cascade: ['persist'])]
    #[Groups(['menu:red:simple','menu:red:complet','catalogues:red:simple'])]
    #[SerializedName('frittes')]
    private $menuFrittes;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTailleBoisson::class, cascade: ['persist'])]
    #[Groups(['catalogues:red:simple','menu:red:complet','menu:red:simple'])]
    #[SerializedName('tailles')]
    private $menuTailleBoissons;

    public function __construct()
    {
        parent::__construct();
        $this->menuBurgers = new ArrayCollection();
        $this->menuFrittes = new ArrayCollection();
        $this->menuTailleBoissons = new ArrayCollection();
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
            $menuBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
        }

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
            $menuFritte->setMenu($this);
        }

        return $this;
    }

    public function removeMenuFritte(MenuFritte $menuFritte): self
    {
        if ($this->menuFrittes->removeElement($menuFritte)) {
            // set the owning side to null (unless already changed)
            if ($menuFritte->getMenu() === $this) {
                $menuFritte->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuTailleBoisson>
     */
    public function getMenuTailleBoissons(): Collection
    {
        return $this->menuTailleBoissons;
    }

    public function addMenuTailleBoisson(MenuTailleBoisson $menuTailleBoisson): self
    {
        if (!$this->menuTailleBoissons->contains($menuTailleBoisson)) {
            $this->menuTailleBoissons[] = $menuTailleBoisson;
            $menuTailleBoisson->setMenu($this);
        }

        return $this;
    }

    public function removeMenuTailleBoisson(MenuTailleBoisson $menuTailleBoisson): self
    {
        if ($this->menuTailleBoissons->removeElement($menuTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($menuTailleBoisson->getMenu() === $this) {
                $menuTailleBoisson->setMenu(null);
            }
        }

        return $this;
    }

    public function AddBurger(Burger $Burger, int $quantite)
    {

        $menuB = new menuBurger();

        $menuB->setQuantite($quantite);
        $menuB->setBurger($Burger);
        $menuB->setMenu($this);
        $this->AddMenuBurger($menuB);
    }
}






























    // #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'menus')]
    // private $boissons;

    // #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
    // private $burgers;

    // #[ORM\ManyToMany(targetEntity: Fritte::class, inversedBy: 'menus')]
    // private $frittes;

    // public function __construct()
    // {
    //     $this->boissons = new ArrayCollection();
    //     $this->burgers = new ArrayCollection();
    //     $this->frittes = new ArrayCollection();
    // }

    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    // /**
    //  * @return Collection<int, Boisson>
    //  */
    // public function getBoissons(): Collection
    // {
    //     return $this->boissons;
    // }

    // public function addBoisson(Boisson $boisson): self
    // {
    //     if (!$this->boissons->contains($boisson)) {
    //         $this->boissons[] = $boisson;
    //     }

    //     return $this;
    // }

    // public function removeBoisson(Boisson $boisson): self
    // {
    //     $this->boissons->removeElement($boisson);

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Burger>
    //  */
    // public function getBurgers(): Collection
    // {
    //     return $this->burgers;
    // }

    // public function addBurger(Burger $burger): self
    // {
    //     if (!$this->burgers->contains($burger)) {
    //         $this->burgers[] = $burger;
    //     }

    //     return $this;
    // }

    // public function removeBurger(Burger $burger): self
    // {
    //     $this->burgers->removeElement($burger);

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Fritte>
    //  */
    // public function getFrittes(): Collection
    // {
    //     return $this->frittes;
    // }

    // public function addFritte(Fritte $fritte): self
    // {
    //     if (!$this->frittes->contains($fritte)) {
    //         $this->frittes[] = $fritte;
    //     }

    //     return $this;
    // }

    // public function removeFritte(Fritte $fritte): self
    // {
    //     $this->frittes->removeElement($fritte);

    //     return $this;
    // }

    //fonction pour ajouter burger

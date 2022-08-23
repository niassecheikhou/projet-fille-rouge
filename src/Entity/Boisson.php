<?php

namespace App\Entity;

use App\Entity\Menu;
use App\Entity\Produit;
use App\Entity\TailleBoisson;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    // collectionOperations :[
    //     "get" => [
    //         'method' => 'get',
    //         'normalization_context' => ['groups' => ['boisson:red:simple']],
    //     ], "post" => [
    //         'denormalization_context' => ['groups' => ['boisson:red:write']]
    //     ]
    // ]
)]
class Boisson extends Produit
{
    #[ORM\ManyToMany(targetEntity: TailleBoisson::class, inversedBy: 'boissons')]
    //  #[Groups(['menu:red:complet'])]
    private Collection $tailleBoissons;

    public function __construct()
    {
        parent::__construct();
        $this->tailleBoissons = new ArrayCollection();
    }

    // #[ORM\ManyToOne(inversedBy: 'boissons')]
    // // #[Groups(['menu:red:complet'])]
    // private ?TailleBoisson $tailleBoisson = null;

    // public function getTailleBoisson(): ?TailleBoisson
    // {
    //     return $this->tailleBoisson;
    // }

    // public function setTailleBoisson(?TailleBoisson $tailleBoisson): self
    // {
    //     $this->tailleBoisson = $tailleBoisson;

    //     return $this;
    // }

    /**
     * @return Collection<int, TailleBoisson>
     */
    public function getTailleBoissons(): Collection
    {
        return $this->tailleBoissons;
    }

    public function addTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        if (!$this->tailleBoissons->contains($tailleBoisson)) {
            $this->tailleBoissons[] = $tailleBoisson;
        }

        return $this;
    }

    public function removeTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        $this->tailleBoissons->removeElement($tailleBoisson);

        return $this;
    }
}

    // #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'boissons')]
    // private $menus;

    // #[ORM\ManyToMany(targetEntity: TailleBoisson::class, inversedBy: 'boissons')]
    // private $boissons;

    // public function __construct()
    // {
    //     $this->menus = new ArrayCollection();
    //     $this->boissons = new ArrayCollection();
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
    //         $menu->addBoisson($this);
    //     }

    //     return $this;
    // }

    // public function removeMenu(Menu $menu): self
    // {
    //     if ($this->menus->removeElement($menu)) {
    //         $menu->removeBoisson($this);
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, TailleBoisson>
    //  */
    // public function getBoissons(): Collection
    // {
    //     return $this->boissons;
    // }

    // public function addBoisson(TailleBoisson $boisson): self
    // {
    //     if (!$this->boissons->contains($boisson)) {
    //         $this->boissons[] = $boisson;
    //     }

    //     return $this;
    // }

    // public function removeBoisson(TailleBoisson $boisson): self
    // {
    //     $this->boissons->removeElement($boisson);

    //     return $this;
    // }


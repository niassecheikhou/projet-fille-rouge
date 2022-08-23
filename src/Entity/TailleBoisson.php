<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
#[ApiResource]
class TailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['groups' => 'menu:red:simple','menu:red:complet','menu','catalogues:red:simple'])]
    private $id;
    
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['groups' => 'menu:red:simple','menu:red:complet','catalogues:red:simple'])]
    private $taille;

    #[ORM\OneToMany(mappedBy: 'tailleBoisson', targetEntity: MenuTailleBoisson::class, cascade: ['persist'])]
    #[Groups(['groups' => 'menu:red:simple','menu:red:simple'])]
    private $menuTailleBoissons;

    #[ORM\ManyToMany(targetEntity: Boisson::class, mappedBy: 'tailleBoissons')]
     #[Groups(['menu:red:simple','catalogues:red:simple','menu:red:complete', 'menu:red:complet'])]
    private Collection $boissons;

    // #[ORM\OneToMany(mappedBy: 'tailleBoisson', targetEntity: Boisson::class, cascade: ['persist'])]
    // #[Groups(['menu:red:simple','catalogues:red:simple','menu:red:complete', 'menu:red:complet'])]
    // private Collection $boissons;

    public function __construct()
    {
        $this->menuTailleBoissons = new ArrayCollection();
        $this->boissons = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): self
    {
        $this->taille = $taille;

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
            $menuTailleBoisson->setTailleBoisson($this);
        }

        return $this;
    }

    public function removeMenuTailleBoisson(MenuTailleBoisson $menuTailleBoisson): self
    {
        if ($this->menuTailleBoissons->removeElement($menuTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($menuTailleBoisson->getTailleBoisson() === $this) {
                $menuTailleBoisson->setTailleBoisson(null);
            }
        }

        return $this;
    }

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
    //         $boisson->setTailleBoisson($this);
    //     }

    //     return $this;
    // }

    // public function removeBoisson(Boisson $boisson): self
    // {
    //     if ($this->boissons->removeElement($boisson)) {
    //         // set the owning side to null (unless already changed)
    //         if ($boisson->getTailleBoisson() === $this) {
    //             $boisson->setTailleBoisson(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
            $boisson->addTailleBoisson($this);
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        if ($this->boissons->removeElement($boisson)) {
            $boisson->removeTailleBoisson($this);
        }

        return $this;
    }
}
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
    //         $boisson->addBoisson($this);
    //     }

    //     return $this;
    // }

    // public function removeBoisson(Boisson $boisson): self
    // {
    //     if ($this->boissons->removeElement($boisson)) {
    //         $boisson->removeBoisson($this);
    //     }

    //     return $this;
    // }
     // #[ORM\ManyToMany(targetEntity: Boisson::class, mappedBy: 'boissons')]
    // private $boissons;

    // public function __construct()
    // {
    //     $this->boissons = new ArrayCollection();
    // }


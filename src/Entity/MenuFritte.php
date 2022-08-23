<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuFritteRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuFritteRepository::class)]
class MenuFritte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['groups' => 'menu:red:simple','catalogues:red:simple','menu:red:complet'])]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuFrittes')]
    private $menu;

    #[ORM\ManyToOne(targetEntity: Fritte::class, inversedBy: 'menuFrittes')]
    #[Groups(['groups' => 'menu:red:simple','catalogues:red:simple','menu:red:complet'])]
    private $fritte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getFritte(): ?Fritte
    {
        return $this->fritte;
    }

    public function setFritte(?Fritte $fritte): self
    {
        $this->fritte = $fritte;

        return $this;
    }
}

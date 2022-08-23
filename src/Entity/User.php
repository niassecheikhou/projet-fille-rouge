<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"role", type:"string")]
#[ORM\DiscriminatorMap(["GESTIONNAIRE"=>"Gestionnaire", "CLIENT"=>"Client","LIVREUR"=>"Livreur"])]
#[ApiResource]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['livreu:red:simple','gestionnaire:red:simple','client:red:simple'])]
    protected $id;

    
    #[Groups(['livreu:red:simple','gestionnaire:red:simple','client:red:simple'])]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    protected $login;

    // #[Groups(['livreu:red:simple','gestionnaire:red:simple','client:red:simple'])]
    #[ORM\Column(type: 'json')]
    protected $roles = [];

    #[ORM\Column(type: 'string')]
    protected $password;
    
    
    #[Groups(['livreu:red:simple','gestionnaire:red:simple','client:red:simple'])]
    #[ORM\Column(type: 'string', length: 255)]
    protected $nomComplet;

    #[ORM\Column(type: 'integer', length: 255,nullable:true)]
    protected $etat;

    #[ORM\Column(type: 'string', length: 255,nullable:true)]
    private $token;

    #[ORM\Column(type: 'boolean',nullable:true)]
    private $isActivated=true;

    #[ORM\Column(type: 'datetime_immutable',nullable:true)]
    private $expireAt;

    
    public function __construct()
    {
        $this->burgers = new ArrayCollection();
    }

    // #[SerializedName('password')]
    // protected $plainPassword;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_VISITEUR';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    // public function getPlainPassword(): ?string
    // {
    //     return $this->plainPassword;
    // }

    // public function setPlainPassword(string $plainPassword): self
    // {
    //     $this->plainPassword = $plainPassword;

    //     return $this;
    // }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function isIsActivated(): ?bool
    {
        return $this->isActivated;
    }

    public function setIsActivated(bool $isActivated): self
    {
        $this->isActivated = $isActivated;

        return $this;
    }

    public function getExpireAt(): ?\DateTimeImmutable
    {
        return $this->expireAt;
    }

    public function setExpireAt(\DateTimeImmutable $expireAt): self
    {
        $this->expireAt = $expireAt;

        return $this;
    }

    
}

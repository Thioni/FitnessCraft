<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email', 'Cette adresse mail est déja utilisée.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email(
      message: 'L\'adresse {{ value }} n\'est pas une adresse valide.',
    )]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\Regex(
      pattern: "$(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\W])$",
      match: true,
      message: 'Votre mot de passe doit comporter au moins huit caractères dont au moins une majuscule, une minuscule, un chiffre et un caractère spécial.',
    )]
    private ?string $password = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Franchisee $franchisee_account = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Structure $structure_account = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

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

    public function getFranchiseeAccount(): ?Franchisee
    {
        return $this->franchisee_account;
    }

    public function setFranchiseeAccount(?Franchisee $franchisee_account): self
    {
        $this->franchisee_account = $franchisee_account;

        return $this;
    }

    public function getStructureAccount(): ?Structure
    {
        return $this->structure_account;
    }

    public function setStructureAccount(?Structure $structure_account): self
    {
        $this->structure_account = $structure_account;

        return $this;
    }
}

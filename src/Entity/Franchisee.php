<?php

namespace App\Entity;

use App\Repository\FranchiseeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: FranchiseeRepository::class)]
#[UniqueEntity('email', 'Cette adresse mail est déja utilisée.')]
class Franchisee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[Assert\Length (
      min: 2,
      max: 60,
      minMessage: 'Le nom doit comporter au moins 2 caractères',
      maxMessage: 'Le nom doit comporter au maximum 20 caractères'
    )]
    private ?string $name = null;

    #[ORM\Column(length: 20)]
    #[Assert\Length (
      min: 2,
      max: 20,
      minMessage: 'Le prénom doit comporter au moins 2 caractères',
      maxMessage: 'Le prénom doit comporter au maximum 20 caractères'
    )]
    private ?string $director_firstname = null;

    #[ORM\Column(length: 20)]
    #[Assert\Length (
      min: 2,
      max: 20,
      minMessage: 'Le nom de famille doit comporter au moins 2 caractères',
      maxMessage: 'Le nom de famille doit comporter au maximum 20 caractères'
    )]
    private ?string $director_lastname = null;

    #[ORM\Column(length: 254)]
    #[Assert\Email(
      message: 'L\'adresse {{ value }} n\'est pas une adresse valide',
    )]
    private ?string $email = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\OneToMany(mappedBy: 'managed_by', targetEntity: Structure::class, orphanRemoval: true)]
    private Collection $structures;

    public function __construct()
    {
        $this->structures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, Structure>
     */
    public function getStructures(): Collection
    {
        return $this->structures;
    }

    public function addStructure(Structure $structure): self
    {
        if (!$this->structures->contains($structure)) {
            $this->structures->add($structure);
            $structure->setManagedBy($this);
        }

        return $this;
    }

    public function removeStructure(Structure $structure): self
    {
        if ($this->structures->removeElement($structure)) {
            // set the owning side to null (unless already changed)
            if ($structure->getManagedBy() === $this) {
                $structure->setManagedBy(null);
            }
        }

        return $this;
    }
    
    public function getDirectorFirstname(): ?string
    {
      return $this->director_firstname;
    }
    
    public function setDirectorFirstname(string $director_firstname): self
    {
      $this->director_firstname = $director_firstname;
      
      return $this;
    }

    public function getDirectorLastName(): ?string
    {
        return $this->director_lastname;
    }
      
    public function setDirectorLastName(string $director_lastname): self
    {
      $this->director_lastname = $director_lastname;
      
      return $this;
    }
    
    public function __toString(): string
    {
      return $this->getName();
    }
    
}

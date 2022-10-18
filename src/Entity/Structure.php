<?php

namespace App\Entity;

use App\Repository\StructureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StructureRepository::class)]
class Structure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[Assert\Length (
      max: 60,
      maxMessage: 'Le nom doit comporter au maximum 60 caractères'
    )]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length (
      min: 10,
      max: 100,
      minMessage: 'L\'adresse doit comporter au moins 10 caractères',
      maxMessage: 'L\'adresse doit comporter au maximum 100 caractères'
    )]
    private ?string $adress = null;

    #[ORM\Column(length: 45)]
    #[Assert\Length (
      min: 2,
      max: 45,
      minMessage: 'Le nom de la ville doit comporter au moins 2 caractères',
      maxMessage: 'Le nom de la ville doit comporter au maximum 45 caractères'
    )]
    private ?string $city = null;

    #[ORM\Column(length: 20)]
    #[Assert\Length (
      min: 2,
      max: 20,
      minMessage: 'Le prénom doit comporter au moins 2 caractères',
      maxMessage: 'Le prénom doit comporter au maximum 20 caractères'
    )]
    private ?string $manager_firstname = null;

    #[ORM\Column(length: 20)]
    #[Assert\Length (
      min: 2,
      max: 20,
      minMessage: 'Le nom de famille doit comporter au moins 2 caractères',
      maxMessage: 'Le nom de famille doit comporter au maximum 20 caractères'
    )]
    private ?string $manager_lastname = null;

    #[ORM\Column(length: 254)]
    #[Assert\Email(
      message: 'L\'email {{ value }} n\'est pas une adresse valide',
    )]
    private ?string $manager_email = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\ManyToOne(inversedBy: 'structures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Franchisee $managed_by = null;

    #[ORM\OneToOne(mappedBy: 'structure', cascade: ['persist', 'remove'])]
    private ?FeaturesList $featuresList = null;

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

    public function getcity(): ?string
    {
      return $this->city;
    }
    
    public function setcity(string $city): self
    {
      $this->city = $city;
      
      return $this;
    }
    
    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getManagerFirstname(): ?string
    {
      return $this->manager_firstname;
    }
    
    public function setManagerFirstname(string $manager_firstname): self
    {
      $this->manager_firstname = $manager_firstname;
      
      return $this;
    }
    
    public function getManagerLastname(): ?string
    {
      return $this->manager_lastname;
    }
    
    public function setManagerLastname(string $manager_lastname): self
    {
      $this->manager_lastname = $manager_lastname;
      
        return $this;
    }

    public function getManagerEmail(): ?string
    {
        return $this->manager_email;
    }

    public function setManagerEmail(string $manager_email): self
    {
        $this->manager_email = $manager_email;

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

    public function getManagedBy(): ?Franchisee
    {
        return $this->managed_by;
    }

    public function setManagedBy(?Franchisee $managed_by): self
    {
        $this->managed_by = $managed_by;

        return $this;
    }

    public function getFeaturesList(): ?FeaturesList
    {
        return $this->featuresList;
    }

    public function setFeaturesList(?FeaturesList $featuresList): self
    {
        // unset the owning side of the relation if necessary
        if ($featuresList === null && $this->featuresList !== null) {
            $this->featuresList->setStructure(null);
        }

        // set the owning side of the relation if necessary
        if ($featuresList !== null && $featuresList->getStructure() !== $this) {
            $featuresList->setStructure($this);
        }

        $this->featuresList = $featuresList;

        return $this;
    }
          
    public function __toString(): string
    {
      return $this->getName();
    }

}    
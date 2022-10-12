<?php

namespace App\Entity;

use App\Repository\StructureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StructureRepository::class)]
class Structure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $adress = null;

    #[ORM\Column(length: 254)]
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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

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

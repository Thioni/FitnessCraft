<?php

namespace App\Entity;

use App\Repository\FeaturesListRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeaturesListRepository::class)]
class FeaturesList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $add_new_members = null;

    #[ORM\Column]
    private ?bool $send_newsletters = null;

    #[ORM\Column]
    private ?bool $planning_manager = null;

    #[ORM\Column]
    private ?bool $sell_drinks = null;

    #[ORM\Column]
    private ?bool $sell_equipment = null;

    #[ORM\Column]
    private ?bool $premium_plans = null;

    #[ORM\OneToOne(inversedBy: 'featuresList', cascade: ['persist', 'remove'])]
    private ?Structure $structure = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAddNewMembers(): ?bool
    {
        return $this->add_new_members;
    }

    public function setAddNewMembers(bool $add_new_members): self
    {
        $this->add_new_members = $add_new_members;

        return $this;
    }

    public function isSendNewsletters(): ?bool
    {
        return $this->send_newsletters;
    }

    public function setSendNewsletters(bool $send_newsletters): self
    {
        $this->send_newsletters = $send_newsletters;

        return $this;
    }

    public function isPlanningManager(): ?bool
    {
        return $this->planning_manager;
    }

    public function setPlanningManager(bool $planning_manager): self
    {
        $this->planning_manager = $planning_manager;

        return $this;
    }

    public function isSellDrinks(): ?bool
    {
        return $this->sell_drinks;
    }

    public function setSellDrinks(bool $sell_drinks): self
    {
        $this->sell_drinks = $sell_drinks;

        return $this;
    }

    public function isSellEquipment(): ?bool
    {
        return $this->sell_equipment;
    }

    public function setSellEquipment(bool $sell_equipment): self
    {
        $this->sell_equipment = $sell_equipment;

        return $this;
    }

    public function isPremiumPlans(): ?bool
    {
        return $this->premium_plans;
    }

    public function setPremiumPlans(bool $premium_plans): self
    {
        $this->premium_plans = $premium_plans;

        return $this;
    }

    public function getStructure(): ?Structure
    {
        return $this->structure;
    }
    
    public function setStructure(?Structure $structure): self
    {
      $this->structure = $structure;
      
      return $this;
    }

    public function structureCheck() {
  
      $dataFeatures = $this->getStructure();

       if ($dataFeatures != null) {
           return false;
       }

      return true;
    }

    public function __toString(): string
    {
      return $this->getStructure();
    }

  }
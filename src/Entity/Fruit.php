<?php

namespace App\Entity;

use App\Repository\FruitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FruitRepository::class)]
class Fruit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $sourceId = null;

    #[ORM\Column(length: 255)]
    private ?string $genus = null;
    #[ORM\Column(length: 255)]
    private ?string $fruitOrder = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $nutritionsCarbohydrates = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $nutritionsProtein = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $nutritionsFat = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $nutritionsCalories = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $nutritionsSugar = null;

    #[ORM\ManyToOne(inversedBy: 'fruits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Family $family = null;

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

    public function getSourceId(): ?int
    {
        return $this->sourceId;
    }

    public function setSourceId(int $sourceId): self
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    public function getGenus(): ?string
    {
        return $this->genus;
    }

    public function setGenus(string $genus): self
    {
        $this->genus = $genus;

        return $this;
    }
    public function getFruitOrder(): ?string
    {
        return $this->fruitOrder;
    }

    public function setFruitOrder(string $fruitOrder): self
    {
        $this->fruitOrder = $fruitOrder;

        return $this;
    }

    public function getNutritionsCarbohydrates(): ?string
    {
        return $this->nutritionsCarbohydrates;
    }

    public function setNutritionsCarbohydrates(string $nutritionsCarbohydrates): self
    {
        $this->nutritionsCarbohydrates = $nutritionsCarbohydrates;

        return $this;
    }

    public function getNutritionsProtein(): ?string
    {
        return $this->nutritionsProtein;
    }

    public function setNutritionsProtein(string $nutritionsProtein): self
    {
        $this->nutritionsProtein = $nutritionsProtein;

        return $this;
    }

    public function getNutritionsFat(): ?string
    {
        return $this->nutritionsFat;
    }

    public function setNutritionsFat(string $nutritionsFat): self
    {
        $this->nutritionsFat = $nutritionsFat;

        return $this;
    }

    public function getNutritionsCalories(): ?string
    {
        return $this->nutritionsCalories;
    }

    public function setNutritionsCalories(string $nutritionsCalories): self
    {
        $this->nutritionsCalories = $nutritionsCalories;

        return $this;
    }

    public function getNutritionsSugar(): ?string
    {
        return $this->nutritionsSugar;
    }

    public function setNutritionsSugar(string $nutritionsSugar): self
    {
        $this->nutritionsSugar = $nutritionsSugar;

        return $this;
    }

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}

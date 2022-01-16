<?php

namespace App\Entity;

use App\Repository\PizzaIngredientsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PizzaIngredientsRepository::class)
 */
class PizzaIngredients
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $extra_cost;

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

    public function getExtraCost(): ?string
    {
        return $this->extra_cost;
    }

    public function setExtraCost(string $extra_cost): self
    {
        $this->extra_cost = $extra_cost;

        return $this;
    }
}

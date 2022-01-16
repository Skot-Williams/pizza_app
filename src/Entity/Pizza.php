<?php

namespace App\Entity;

use App\Repository\PizzaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PizzaRepository::class)
 */
class Pizza
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
     * @ORM\OneToOne(targetEntity=PizzaPriceList::class, mappedBy="pizza_id", cascade={"persist", "remove"})
     */
    private $cost;

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

    public function getCost(): ?PizzaPriceList
    {
        return $this->cost;
    }

    public function setCost(?PizzaPriceList $cost): self
    {
        // unset the owning side of the relation if necessary
        if ($cost === null && $this->cost !== null) {
            $this->cost->setPizzaId(null);
        }

        // set the owning side of the relation if necessary
        if ($cost !== null && $cost->getPizzaId() !== $this) {
            $cost->setPizzaId($this);
        }

        $this->cost = $cost;

        return $this;
    }
}

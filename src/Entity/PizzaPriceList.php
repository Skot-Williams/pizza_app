<?php

namespace App\Entity;

use App\Repository\PizzaPriceListRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PizzaPriceListRepository::class)
 */
class PizzaPriceList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Pizza::class, inversedBy="cost", cascade={"persist", "remove"})
     */
    private $pizza_id;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2)
     */
    private $item_cost;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPizzaId(): ?Pizza
    {
        return $this->pizza_id;
    }

    public function setPizzaId(?Pizza $pizza_id): self
    {
        $this->pizza_id = $pizza_id;

        return $this;
    }

    public function getItemCost(): ?string
    {
        return $this->item_cost;
    }

    public function setItemCost(string $item_cost): self
    {
        $this->item_cost = $item_cost;

        return $this;
    }
}

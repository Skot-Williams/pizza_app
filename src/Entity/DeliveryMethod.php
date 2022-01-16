<?php

namespace App\Entity;

use App\Repository\DeliveryMethodRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeliveryMethodRepository::class)
 */
class DeliveryMethod
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
    private $method_name;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $type;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2)
     */
    private $cost;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMethodName(): ?string
    {
        return $this->method_name;
    }

    public function setMethodName(string $method_name): self
    {
        $this->method_name = $method_name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCost(): ?string
    {
        return $this->cost;
    }

    public function setCost(string $cost): self
    {
        $this->cost = $cost;

        return $this;
    }
}

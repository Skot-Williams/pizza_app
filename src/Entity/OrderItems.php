<?php

namespace App\Entity;

use App\Repository\OrderItemsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderItemsRepository::class)
 */
class OrderItems
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Orders::class, inversedBy="orderItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $order_id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $order_item_type;

    /**
     * @ORM\Column(type="integer")
     */
    private $order_item_pizza_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?Orders
    {
        return $this->order_id;
    }

    public function setOrderId(?Orders $order_id): self
    {
        $this->order_id = $order_id;

        return $this;
    }

    public function getOrderItemType(): ?string
    {
        return $this->order_item_type;
    }

    public function setOrderItemType(string $order_item_type): self
    {
        $this->order_item_type = $order_item_type;

        return $this;
    }

    public function getOrderItemPizzaId(): ?int
    {
        return $this->order_item_pizza_id;
    }

    public function setOrderItemPizzaId(int $order_item_pizza_id): self
    {
        $this->order_item_pizza_id = $order_item_pizza_id;

        return $this;
    }
}

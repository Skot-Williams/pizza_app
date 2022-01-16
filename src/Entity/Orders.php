<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdersRepository::class)
 */
class Orders
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=DeliveryMethod::class, cascade={"persist", "remove"})
     */
    private $delivery_method_id;

    /**
     * @ORM\OneToOne(targetEntity=DeliveryDriver::class, cascade={"persist", "remove"})
     */
    private $delivery_driver_id;

    /**
     * @ORM\OneToMany(targetEntity=OrderItems::class, mappedBy="order_id")
     */
    private $orderItems;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeliveryMethodId(): ?DeliveryMethod
    {
        return $this->delivery_method_id;
    }

    public function setDeliveryMethodId(?DeliveryMethod $delivery_method_id): self
    {
        $this->delivery_method_id = $delivery_method_id;

        return $this;
    }

    public function getDeliveryDriverId(): ?DeliveryDriver
    {
        return $this->delivery_driver_id;
    }

    public function setDeliveryDriverId(?DeliveryDriver $delivery_driver_id): self
    {
        $this->delivery_driver_id = $delivery_driver_id;

        return $this;
    }

    /**
     * @return Collection|OrderItems[]
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItems $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems[] = $orderItem;
            $orderItem->setOrderId($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItems $orderItem): self
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrderId() === $this) {
                $orderItem->setOrderId(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Stock::class, mappedBy="product")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

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

    /**
     * @return Collection|Stock[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Stock $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addProduct($this);
        }

        return $this;
    }

    public function removeProduct(Stock $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeProduct($this);
        }

        return $this;
    }
}

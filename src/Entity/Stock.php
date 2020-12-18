<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StockRepository::class)
 */
class Stock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="products")
     */
    private $product;

    /**
     * @ORM\ManyToMany(targetEntity=Magasin::class, mappedBy="stock")
     */
    private $magasins_stock;

    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->magasins_stock = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->product->removeElement($product);

        return $this;
    }

    /**
     * @return Collection|Magasin[]
     */
    public function getMagasinsStock(): Collection
    {
        return $this->magasins_stock;
    }

    public function addMagasinsStock(Magasin $magasinsStock): self
    {
        if (!$this->magasins_stock->contains($magasinsStock)) {
            $this->magasins_stock[] = $magasinsStock;
            $magasinsStock->addStock($this);
        }

        return $this;
    }

    public function removeMagasinsStock(Magasin $magasinsStock): self
    {
        if ($this->magasins_stock->removeElement($magasinsStock)) {
            $magasinsStock->removeStock($this);
        }

        return $this;
    }
}

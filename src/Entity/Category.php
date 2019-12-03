<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", mappedBy="categories")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductPosition", mappedBy="category", orphanRemoval=true)
     */
    private $productPositions;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->productPositions = new ArrayCollection();
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
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            $product->removeCategory($this);
        }

        return $this;
    }

    /**
     * @return Collection|ProductPosition[]
     */
    public function getProductPositions(): Collection
    {
        return $this->productPositions;
    }

    public function addProductPosition(ProductPosition $productPosition): self
    {
        if (!$this->productPositions->contains($productPosition)) {
            $this->productPositions[] = $productPosition;
            $productPosition->setCategory($this);
        }

        return $this;
    }

    public function removeProductPosition(ProductPosition $productPosition): self
    {
        if ($this->productPositions->contains($productPosition)) {
            $this->productPositions->removeElement($productPosition);
            // set the owning side to null (unless already changed)
            if ($productPosition->getCategory() === $this) {
                $productPosition->setCategory(null);
            }
        }

        return $this;
    }
}

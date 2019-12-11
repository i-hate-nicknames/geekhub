<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $qty;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductPosition", mappedBy="product", orphanRemoval=true)
     */
    private $productPositions;

    public function __construct()
    {
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->getProductPositions()->map(function ($position) {
            return $position->getCategory();
        });
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $productPosition->setProduct($this);
        }

        return $this;
    }

    public function removeProductPosition(ProductPosition $productPosition): self
    {
        if ($this->productPositions->contains($productPosition)) {
            $this->productPositions->removeElement($productPosition);
            // set the owning side to null (unless already changed)
            if ($productPosition->getProduct() === $this) {
                $productPosition->setProduct(null);
            }
        }

        return $this;
    }
}

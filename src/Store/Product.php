<?php

namespace GeekhubShop\Store;

class Product
{
    /** @var string */
    private $name;

    /** @var int */
    private $qty;

    /** @var Category */
    private $category;

    /** @var float */
    private $price;

    /**
     * Product constructor.
     * @param string $name
     * @param int $qty
     * @param float $price
     */
    public function __construct(string $name, int $qty, float $price)
    {
        $this->name = $name;
        $this->qty = $qty;
        $this->price = $price;
    }

    /**
     * @param Product $other
     * @return bool true if this is the same product as $other
     */
    public function equals(Product $other): bool
    {
        return $this->getName() === $other->getName();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getId()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * @param int $qty
     */
    public function setQty($qty)
    {
        $this->qty = $qty;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}

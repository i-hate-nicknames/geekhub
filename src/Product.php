<?php

namespace GeekhubShop;

class Product
{
    /** @var string */
    private $name;

    /** @var int */
    private $qty;

    /** @var int */
    private $category;

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
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param int $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
}

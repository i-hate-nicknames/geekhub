<?php

namespace App\Entity;

class Category
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var array */
    private $products = [];

    /**
     * Category constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param array $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @param Product $product
     * @return bool
     */
    public function hasProduct(Product $product): bool
    {
        foreach ($this->products as $existingProduct) {
            if ($existingProduct->equals($product)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param Product $product
     * @throws \Exception when the product already belongs to this category
     */
    public function addProduct(Product $product)
    {
        if ($this->hasProduct($product)) {
            throw new \Exception(sprintf('Product %s already belongs to this category', $product->getName()));
        }
        $this->products[] = $product;
    }

    /**
     * @param Product $productToRemove
     * @throws \Exception when the product does not belong to this category
     */
    public function removeProduct(Product $productToRemove)
    {
        if (!$this->hasProduct($productToRemove)) {
            throw new \Exception(sprintf('Product %s doesn\'t belong to this category', $productToRemove->getName()));
        }
        $this->products = array_filter($this->products, function (Product $product) use ($productToRemove) {
            return !$productToRemove->equals($product);
        });
    }
}

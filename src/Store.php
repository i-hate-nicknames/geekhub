<?php

namespace GeekhubShop;

class Store
{
    /** @var Database */
    private $db;

    /**
     * Store constructor.
     * @param Database $db
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getCategories(): array
    {
        throw new \Exception('Not implemented');
    }

    /**
     * @param int $categoryId
     * @return Category
     * @throws \Exception
     */
    public function getCategory(int $categoryId): Category
    {
        throw new \Exception('Not implemented');
    }

    /**
     * @param string $productId
     * @return Product
     * @throws \Exception
     */
    public function getProduct(string $productId): Product
    {
        throw new \Exception('Not implemented');
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getProducts(): array
    {
        return $this->db->getProducts();
    }

    /**
     * @param Product $product
     * @param Category $from
     * @param Category $to
     * @throws \Exception
     */
    public function move(Product $product, Category $from, Category $to)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * @param string $name
     * @param int $qty
     * @return Product
     */
    public function addProduct(string $name, int $qty): Product
    {
        $product = new Product($name, $qty);
        $this->db->addProduct($product);
        $this->persist();
        return $product;
    }

    /**
     * Save current state of the store to the disk.
     * This method should be called after editing product
     */
    public function persist()
    {
        $this->db->save();
    }
}
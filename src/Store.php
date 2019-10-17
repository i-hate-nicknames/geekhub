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
     * @param string $productName
     * @return Product
     * @throws \Exception
     */
    public function getProduct(string $productName): Product
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
        throw new \Exception('Not implemented');
    }
}
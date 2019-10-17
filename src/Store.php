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
        return $this->db->getCategories();
    }

    /**
     * @param int $categoryId
     * @return Category
     * @throws \Exception
     */
    public function getCategory(int $categoryId): Category
    {
        $cat = $this->db->getCategory($categoryId);
        if ($cat === null) {
            throw new \Exception("Category with id $categoryId not found!");
        }
        return $cat;
    }

    /**
     * @param string $categoryName
     * @return Category
     * @throws \Exception
     */
    public function getCategoryByName(string $categoryName): Category
    {
        $cat = $this->db->getCategoryByName($categoryName);
        if ($cat === null) {
            throw new \Exception("Category with name $categoryName not found!");
        }
        return $cat;
    }

    /**
     * @param string $productId
     * @return Product
     * @throws \Exception
     */
    public function getProduct(string $productId): Product
    {
        $product = $this->db->getProduct($productId);
        if ($product === null) {
            throw new \Exception("Product $productId not found!");
        }
        return $product;
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
     * Move product identified by $productName to $targetCategory
     * @param string $productName
     * @param string $targetCategory
     * @throws \Exception if either product or category do not exist
     */
    public function move(string $productName, string $targetCategory)
    {
        $product = $this->getProduct($productName);
        $product->setCategory($this->getCategoryByName($targetCategory));
        $this->persist();
    }

    /**
     * @param string $name
     * @param int $qty
     * @return Product
     * @throws \Exception
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
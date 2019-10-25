<?php

namespace GeekhubShop\Store;

class Store
{
    public const NO_CATEGORY = 'None';

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
     * @param int $productId
     * @return Product
     * @throws \Exception
     */
    public function getProduct(int $productId): Product
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
    public function getAllProducts(): array
    {
        return $this->db->getProducts();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getProductsGroupedByCategory(): array
    {
        $grouped = [];
        /** @var Product $product */
        foreach ($this->getAllProducts() as $product) {
            $cat = $product->getCategory();
            $catName = ($cat !== null) ? $cat->getName() : self::NO_CATEGORY;
            if (!array_key_exists($catName, $grouped)) {
                $grouped[$catName] = [];
            }
            $grouped[$catName][] = $product;
        }
        return $grouped;
    }

    /**
     * Move product identified by $productName to $targetCategory
     * @param string $productName
     * @param string $targetCategoryName
     * @throws \Exception if either product or category do not exist
     */
    public function move(string $productName, string $targetCategoryName)
    {
        if (strtolower($targetCategoryName) === strtolower(self::NO_CATEGORY)) {
            throw new \Exception('Removing products from categories is not allowed');
        }
        $product = $this->getProduct($productName);
        $targetCategory = $this->getCategoryByName($targetCategoryName);
        $product->setCategory($targetCategory);
        $targetCategory->addProduct($product);
        $this->persist();
    }

    /**
     * @param string $name
     * @param int $qty
     * @param float $price
     * @return Product
     * @throws \Exception
     */
    public function createProduct(string $name, int $qty, float $price): Product
    {
        $product = new Product(null, $name, $qty, $price);
        $this->db->addProduct($product);
        $this->persist();
        return $product;
    }

    /**
     * Save current state of the Store to the disk.
     * This method should be called after editing product
     */
    public function persist()
    {
        $this->db->save();
    }
}
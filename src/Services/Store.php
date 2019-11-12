<?php

namespace App\Services;

use App\Entity\Category;
use App\Entity\Product;
use Psr\Log\LoggerInterface;
use function array_filter;
use function array_merge;
use function sprintf;

class Store
{
    public const NO_CATEGORY = 'None';

    /** @var Database */
    private $db;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Store constructor.
     * @param Database $db
     */
    public function __construct(Database $db, LoggerInterface $logger)
    {
        $this->db = $db;
        $this->logger = $logger;
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
        $this->logger->info('Created new product, id = ' . $product->getId());
        return $product;
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
        $oldCategory = $product->getCategory();
        $targetCategory = $this->getCategoryByName($targetCategoryName);
        if ($oldCategory !== null) {
            $this->removeProductFromCategory($oldCategory, $product);
        }
        $this->addProductToCategory($targetCategory, $product);
        $this->persist();
        $message = sprintf(
            'Moved product %s from %s to %s',
            $productName,
            $oldCategory->getName(),
            $targetCategoryName
        );
        $this->logger->info($message);
    }

    /**
     * @param Category $category
     * @param Product $product
     * @throws \Exception
     */
    private function removeProductFromCategory(Category $category, Product $product)
    {
        $this->validateContains($category, $product);
        $products = array_filter($category->getProducts(), function (Product $catProduct) use ($product) {
            return $catProduct->getId() !== $product->getId();
        });
        $category->setProducts($products);
        $product->setCategory(null);
    }

    /**
     * @param Category $category
     * @param Product $product
     * @throws \Exception
     */
    private function addProductToCategory(Category $category, Product $product)
    {
        $this->validateContains($category, $product);
        $products = array_merge($category->getProducts(), [$product]);
        $category->setProducts($products);
        $product->setCategory($category);
    }

    /**
     * @param Category $category
     * @param Product $product
     * @return bool
     */
    private function hasProduct(Category $category, Product $product): bool
    {
        foreach ($category->getProducts() as $existingProduct) {
            if ($existingProduct->getId() === $product->getId()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Validate if given category contains given product, and that the product category is
     * set to the category
     * @param Category $category
     * @param Product $product
     * @throws \Exception
     */
    private function validateContains(Category $category, Product $product)
    {
        if (!$this->hasProduct($category, $product)) {
            throw new \Exception(sprintf(
                'Product %s doesn\'t belong to the category %s',
                $product->getName(),
                $category->getName()
            ));
        }
    }

    /**
     * Save current state of the Store to the disk.
     * This method should be called after editing product
     */
    private function persist()
    {
        $this->db->save();
    }
}

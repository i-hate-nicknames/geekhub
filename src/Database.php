<?php

namespace GeekhubShop;

class Database
{
    private $dbFile;

    /** @var array */
    private $categories = [];

    /** @var array */
    private $products = [];

    private $loaded;

    public function __construct(string $dbFile)
    {
        $this->dbFile = $dbFile;
    }

    public function load()
    {
        if ($this->loaded) {
            return;
        }
        $data = file_get_contents($this->dbFile);
        if ($data === false) {
            throw new \Exception('Error reading database file');
        }
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception(json_last_error_msg());
        }
        $db = json_decode($data, true);
        foreach ($db['categories'] as $catDefinition) {
            $cat = new Category($catDefinition['id'], $catDefinition['name']);
            $this->categories[$cat->getId()] = $cat;
        }
        foreach ($db['products'] as $productDefinition) {
            $product = new Product($productDefinition['name'], $productDefinition['qty']);
            $this->products[$product->getId()] = $product;
            if (array_key_exists('category', $productDefinition)) {
                $catId = $productDefinition['category'];
                $cat = $this->categories[$catId];
                if ($cat === null) {
                    throw new \Exception(sprintf('Product %s references non-existent category: %d',
                        $product->getName(), $catId));
                }
                $product->setCategory($cat);
                $cat->addProduct($product);
            }
        }
        $this->loaded = true;
    }

    public function save()
    {
        $cats = [];
        $products = [];
        foreach ($this->products as $product) {
            $products[] = $this->serializeProduct($product);
        }
        foreach ($this->categories as $cat) {
            $cats[] = $this->serializeCategory($cat);
        }
        $db = [
            'products' => $products,
            'categories' => $cats
        ];
        file_put_contents($this->dbFile, json_encode($db));
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getCategories(): array
    {
        $this->load();
        return $this->categories;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getProducts(): array
    {
        $this->load();
        return $this->products;
    }

    /**
     * @param string $productId
     * @return Product|null
     * @throws \Exception when failed to load db
     */
    public function getProduct(string $productId): ?Product
    {
        return $this->getProducts()[$productId];
    }

    /**
     * @param int $id
     * @return Category|null
     * @throws \Exception
     */
    public function getCategory(int $id): ?Category
    {
        return $this->getCategories()[$id];
    }

    /**
     * Add given product to the database
     * @param Product $product
     * @throws \Exception
     */
    public function addProduct(Product $product)
    {
        $this->load();
        $this->products[$product->getId()] = $product;
    }

    private function serializeProduct(Product $product): array
    {
        $result = [
            'name' => $product->getName(),
            'qty' => (int) $product->getQty()
        ];
        if ($product->getCategory() !== null) {
            $result['category'] = (int) $product->getCategory()->getId();
        }
        return $result;
    }

    private function serializeCategory(Category $category): array
    {
        return [
            'name' => $category->getName(),
            'id' => (int) $category->getId(),
        ];
    }

    /**
     * @param string $categoryName
     * @return Category|null
     * @throws \Exception
     */
    public function getCategoryByName(string $categoryName): ?Category
    {
        $this->load();
        /** @var Category $cat */
        foreach ($this->categories as $cat) {
            if ($cat->getName() === $categoryName) {
                return $cat;
            }
        }
        return null;
    }
}

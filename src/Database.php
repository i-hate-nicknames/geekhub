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
            $this->products[$product->getName()] = $product;
            if (array_key_exists('category', $productDefinition)) {
                $catId = $productDefinition['category'];
                $cat = $this->categories[$catId];
                if ($cat === null) {
                    throw new \Exception(sprintf('Product %s references non-existent category: %d',
                        $product->getName(), $catId));
                }
                $product->setCategory($cat);
            }
        }
        $this->loaded = true;
    }

    public function save()
    {

    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        $this->load();
        return $this->categories;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        $this->load();
        return $this->products;
    }
}

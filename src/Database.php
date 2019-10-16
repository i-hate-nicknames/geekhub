<?php

namespace GeekhubShop;

class Database
{
    private $dbFile;

    /** @var array */
    private $categories;

    /** @var array */
    private $products;

    public function __construct(string $dbFile)
    {
        $this->dbFile = $dbFile;
    }

    public function load()
    {

    }

    public function save()
    {

    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }
}

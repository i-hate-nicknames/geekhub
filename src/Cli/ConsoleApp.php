<?php

namespace GeekhubShop\Cli;

use GeekhubShop\Store\Category;
use GeekhubShop\Store\Database;
use GeekhubShop\Store\Product;
use GeekhubShop\Store\Store;

class ConsoleApp
{
    const DB_FILE = __DIR__ . '/../../data/database.json';

    const TABLE_PAD = 12;

    /** @var Store */
    private $store;

    public function __construct()
    {
        $this->store = new Store(new Database(self::DB_FILE));
    }

    /**
     * Move product to given category. Expect arguments in form
     * <product name> <category name>
     * @param $args
     */
    public function moveProduct($args)
    {
        $this->runSafe('moveProduct', $args);
    }

    /**
     * Add new product to the store
     * Expect arguments in form
     * <product name> <product quantity> <category name>
     * @param $args
     */
    public function createProduct($args)
    {
        $this->runSafe('createProduct', $args);
    }

    private function runSafe($command, $args)
    {
        try {
            $this->run($command, $args);
        } catch (\Exception $e) {
            $this->println($e->getMessage());
        }
    }

    /**
     * @param $command
     * @param $args
     * @throws \Exception
     */
    private function run($command, $args)
    {
        // strip off first argument, the name of the program invoked
        $actualArgs = array_slice($args, 1);
        // TODO: validating arguments (their number and types) would be nice
        switch ($command) {
            case 'showProducts':
                $this->showProducts();
                break;
            case 'createProduct':
                if (count($actualArgs) != 3) {
                    $this->println('Please provide name, quantity and price for new product');
                    return;
                }
                $this->store->createProduct($actualArgs[0], $actualArgs[1], $actualArgs[2]);
                break;
            case 'moveProduct':
                if (count($actualArgs) != 2) {
                    $this->println('Usage: product_name target_category');
                    return;
                }
                $this->store->move($actualArgs[0], $actualArgs[1]);
                $this->showProducts();
                break;
            default:
                $this->println('Unknown command: %s', $command);
        }
    }

    /**
     * Print a single table row to stdout, padding each element in $elements
     * by $padLength and joining them via ` | `
     * @param $padLength
     * @param $elements
     */
    private function printTableRow($padLength, $elements)
    {
        $padded = array_map(function ($el) use ($padLength) {
            return str_pad($el, $padLength);
        },
            $elements);
        $row = implode(' | ', $padded);
        $this->println($row);
    }

    /**
     * @throws \Exception
     */
    private function showProducts()
    {
        $this->printTableRow(self::TABLE_PAD, ['Category', 'Name', 'Price', 'Quantity']);
        foreach ($this->store->getProductsGroupedByCategory() as $catName => $products) {
            /** @var Product $product */
            foreach ($products as $product) {
                $price = sprintf("%.2f", $product->getPrice());
                $this->printTableRow(self::TABLE_PAD, [$catName, $product->getName(), $price, $product->getQty()]);
            }
        }
    }

    /**
     * Perform printf to format string and arguments, but append a newline symbol to $formatString
     * @param $formatString
     * @param array $args
     */
    private function println($formatString, ...$args)
    {
        printf($formatString . "\n", ...$args);
    }
}
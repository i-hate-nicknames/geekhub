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

    public function moveProduct($args)
    {
        $this->runSafe('moveProduct', $args);
    }

    public function addProduct($args)
    {
        $this->runSafe('addProduct', $args);
    }

    private function runSafe($command, $args)
    {
        try {
            $this->run($command, $args);
        } catch (\Exception $e) {
            printf($e->getMessage() . "\n");
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
        switch ($command) {
            case 'showProducts':
                $this->showProducts();
                break;
            case 'createProduct':
                if (count($actualArgs) != 2) {
                    printf("Please provide name and quantity for new product\n");
                    return;
                }
                $this->store->addProduct($actualArgs[0], (int) $actualArgs[1]);
                break;
            case 'moveProduct':
                if (count($actualArgs) != 2) {
                    printf("Usage: product_name target_category\n");
                    return;
                }
                $this->store->move($actualArgs[0], $actualArgs[1]);
                $this->showProducts();
                break;
            default:
                printf("Unknown command: %s\n", $command);
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
        $padded = array_map(function ($el) use ($padLength) { return str_pad($el, $padLength);}, $elements);
        $row = implode(' | ', $padded) . "\n";
        printf($row);
    }

    /**
     * @throws \Exception
     */
    private function showProducts() {
        $this->printTableRow(self::TABLE_PAD, ['Category', 'Name', 'Quantity']);
        /** @var Category $cat */
        foreach ($this->store->getCategories() as $cat) {
            /** @var Product $product */
            foreach ($cat->getProducts() as $product) {
                $this->printTableRow(self::TABLE_PAD, [$cat->getName(), $product->getName(), $product->getQty()]);
            }
        }
    }
}
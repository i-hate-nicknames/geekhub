<?php

use GeekhubShop\Database;
use GeekhubShop\Product;
use GeekhubShop\Store;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

function initStore(): Store {
    $dbFile = __DIR__ . '/../data/database.json';
    $db = new Database($dbFile);
    return new Store($db);
}

function run($args) {
    if (count($args) == 1) {
        printf("Please provide a command to run as an argument\n");
        return;
    }
    $command = $args[1];
    $actualArgs = array_slice($args, 2);
    switch ($command) {
        case 'showProducts':
            showProducts();
            break;
        case 'createProduct':
            if (count($actualArgs) != 2) {
                printf("Please provide name and quantity for new product\n");
                return;
            }
            createProduct($actualArgs[0], (int) $actualArgs[1]);
            break;
        case 'moveProduct':
            if (count($actualArgs) != 2) {
                printf("Usage: product_name target_category\n");
                return;
            }
            moveProduct($actualArgs[0], $actualArgs[1]);
            showProducts();
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
function printTableRow($padLength, $elements) {
    $padded = array_map(function ($el) use ($padLength) { return str_pad($el, $padLength);}, $elements);
    $row = implode(' | ', $padded) . "\n";
    printf($row);
}

function showProducts() {
    $store = initStore();
    $tablePad = 12;
    printTableRow($tablePad, ['Name', 'Category', 'Quantity']);
    /** @var Product $product */
    foreach ($store->getProducts() as $product) {
        $catName = ($product->getCategory()) ? $product->getCategory()->getName() : 'No category';
        printTableRow($tablePad, [$product->getName(), $catName, $product->getQty()]);
    }
}

function createProduct(string $name, int $qty) {
    $store = initStore();
    $store->addProduct($name, $qty);
}

function moveProduct(string $productName, string $targetCategory) {
    $store = initStore();
    $store->move($productName, $targetCategory);
}

run($argv);

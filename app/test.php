<?php

use GeekhubShop\Database;
use GeekhubShop\Product;
use GeekhubShop\Store;

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
        $product->setQty(15);
    }
    $store->persist();
}

run($argv);

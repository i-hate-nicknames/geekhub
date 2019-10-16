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

function showProducts() {
    $store = initStore();
    /** @var Product $product */
    foreach ($store->getProducts() as $product) {
        printf("%s\t|%s\t|%s", $product->getName(), $product->getCategory(), $product->getQty());
    }
}

run($argv);

<?php


namespace App\Services;

use App\Entity\Category;
use App\Entity\Product;
use function array_filter;
use function array_merge;
use function sprintf;

class CategoryManager
{
    public function removeProduct(Category $category, Product $product)
    {
        if (!$category->hasProduct($product)) {
            throw new \Exception(sprintf('Product %s doesn\'t belong to this category', $product->getName()));
        }
        $products = array_filter($category->getProducts(), function (Product $catProduct) use ($product) {
            return $catProduct->getId() !== $product->getId();
        });
        $category->setProducts($products);
    }

    public function addProduct(Category $category, Product $product)
    {
        if ($category->hasProduct($product)) {
            throw new \Exception(sprintf('Product %s already belongs to this category', $product->getName()));
        }
        $products = array_merge($category->getProducts(), [$product]);
        $category->setProducts($products);
    }
}

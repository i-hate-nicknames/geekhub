<?php

namespace App\Services;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Common\Persistence\ManagerRegistry;
use http\Exception\RuntimeException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Intl\Exception\NotImplementedException;

class Store
{
    public const NO_CATEGORY = 'None';

    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var Notifier
     */
    private $notifier;
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * Store constructor.
     * @param ManagerRegistry $doctrine
     * @param LoggerInterface $logger
     * @param Notifier $notifier
     */
    public function __construct(ManagerRegistry $doctrine, LoggerInterface $logger, Notifier $notifier)
    {
        $this->logger = $logger;
        $this->notifier = $notifier;
        $this->doctrine = $doctrine;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getProductsGroupedByCategory(): array
    {
        $products = $this->doctrine->getRepository(Product::class)->findAll();
        $grouped = [];
        /** @var Product $product */
        foreach ($products as $product) {
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
     * @param int $price
     * @param $description
     * @return Product
     */
    public function createProduct(string $name, int $qty, int $price, $description): Product
    {
        $entityManager = $this->doctrine->getManager();
        $product = new Product();
        $product->setName($name)
            ->setQty($qty)
            ->setDescription($description)
            ->setPrice($price);
        $entityManager->persist($product);
        $entityManager->flush();
        $message = 'Created new product, id = ' . $product->getId();
        $this->logger->info($message);
        $this->notifier->notify($message);
        return $product;
    }

    /**
     * @param string $name
     */
    public function createCategory(string $name)
    {
        $category = new Category();
        $category->setName($name);
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($category);
        $entityManager->flush();
    }

    /**
     * Move product to the specified category
     * @param int $productId
     * @param int $toId
     */
    public function move(int $productId, int $toId)
    {
        $product = $this->doctrine->getRepository(Product::class)->find($productId);
        $targetCategory = $this->doctrine->getRepository(Category::class)->find($toId);
        if (null === $product) {
            throw new NotFoundHttpException("Product with id = $product doesnt exist");
        }
        if (null === $targetCategory) {
            throw new NotFoundHttpException("Category with id = $toId doesnt exist");
        }
        $product->setCategory($targetCategory);
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($product);
        $entityManager->flush();
    }
}

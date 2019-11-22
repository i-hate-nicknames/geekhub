<?php

namespace App\Services;

use App\Entity\Product;
use Doctrine\Common\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
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
     * Move product to the specified category
     * @param int $productId
     * @param int $targetCategoryId
     */
    public function move(int $productId, int $targetCategoryId)
    {
        throw new NotImplementedException('Moving is not implemented yet');
    }
}

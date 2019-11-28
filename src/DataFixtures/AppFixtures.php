<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $cats = [];
        for ($i = 0; $i < 5; ++$i) {
            $category = new Category();
            $category->setName('cat' . $i);
            $manager->persist($category);
            $cats[] = $category;
        }

        for ($i = 0; $i < 50; ++$i) {
            $product = new Product();
            $product->setName('product' . $i)
                ->setDescription('descr' . $i)
                ->setPrice(10 * $i)
                ->setQty(2 * $i)
                ->addCategory($cats[$i/10]);
            $manager->persist($product);
        }
        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    const NUM_USERS = 20;
    const NUM_CATEGORIES = 30;
    const NUM_PRODUCTS = 100;

    public function load(ObjectManager $manager)
    {
        $users = [];
        for ($i = 0; $i < self::NUM_USERS; ++$i) {
            $user = new User();
            $user->setName('user' . $i);
            $manager->persist($user);
            $users[] = $user;
        }
        $cats = [];
        for ($i = 0; $i < self::NUM_CATEGORIES; ++$i) {
            $category = new Category();
            $category->setName('cat' . $i);
            $manager->persist($category);
            $cats[] = $category;
        }

        for ($i = 0; $i < self::NUM_PRODUCTS; ++$i) {
            $productUser = $users[$i % self::NUM_USERS];
            $product = new Product();
            $product->setName('product' . $i)
                ->setDescription('descr' . $i)
                ->setPrice(10 * $i)
                ->setQty(2 * $i)
                ->addCategory($cats[$i % self::NUM_CATEGORIES])
                ->setUser($productUser);
            $productUser->addProduct($product);
            $manager->persist($product);
        }
        $manager->flush();
    }
}

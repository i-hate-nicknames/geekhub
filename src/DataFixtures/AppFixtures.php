<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    const NUM_USERS = 5;
    const NUM_CATEGORIES = 30;
    const NUM_PRODUCTS = 100;

    public function load(ObjectManager $manager)
    {
        $users = [];
        for ($i = 0; $i < self::NUM_USERS; ++$i) {
            $user = new User();
            $user->setName('user' . $i)
                ->setAge($i)
                ->setMale($i % 2 === 0);
            $manager->persist($user);
            $users[] = $user;
        }
        $cats = [];
        for ($i = 0; $i < self::NUM_CATEGORIES; ++$i) {
            $category = new Category();
            $category->setTitle('cat' . $i);
            $manager->persist($category);
            $cats[] = $category;
        }

        for ($i = 0; $i < self::NUM_PRODUCTS; ++$i) {
            $product = new Product();
            $product->setTitle('product' . $i)
                ->setPrice(10 * $i)
                ->setCreatedAt(new DateTime())
                ->addUser($users[$i % self::NUM_USERS])
                ->setUpdatedAt(new DateTime());
            if ($i % 2 === 0) {
                // for every second product add another user
                $product->addUser($users[($i+1) % self::NUM_USERS]);
            }
            $cat = $cats[$i % self::NUM_CATEGORIES];
            $cat->addProduct($product);
            $manager->persist($cat);

            $manager->persist($product);
        }
        $manager->flush();
    }
}

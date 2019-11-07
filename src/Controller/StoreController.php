<?php

namespace App\Controller;

use App\Models\Database;
use App\Models\Store;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreController extends AbstractController
{
    public const DB_FILE = '/data/database.json';

    /**
     * @Route("/")
     * @return Response
     */
    public function hello()
    {
        $store = $this->getStore();
        return new JsonResponse($store->getProductsGroupedByCategory());
    }

    private function getStore()
    {
        $db = new Database(self::DB_FILE);
        return new Store($db);
    }
}

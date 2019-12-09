<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     * @throws \Exception
     */
    public function home()
    {
        return $this->redirectToRoute('categories');
    }

    /**
     * @Route("/categories", name="categories")
     * @return Response
     * @throws \Exception
     */
    public function categories()
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        return $this->render('categories.html.twig', ['categories' => $repository->findAll()]);
    }

    /**
     * @Route("/products", name="products")
     * @return Response
     * @throws \Exception
     */
    public function products()
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        return $this->render('products.html.twig', ['products' => $repository->findAll()]);
    }

    /**
     * @Route("/users", name="users")
     * @return Response
     * @throws \Exception
     */
    public function users()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        return $this->render('users.html.twig', ['users' => $repository->findAll()]);
    }
}

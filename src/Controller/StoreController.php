<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use App\Forms\ProductType;
use App\Forms\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/testTwig", name="testTwig")
     * @return Response
     */
    public function testTwig()
    {
        return $this->render('test-twig.html.twig');
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
        $user = $this->getActiveUser();
        $repository = $this->getDoctrine()->getRepository(Product::class);
        return $this->render('products.html.twig', ['products' => $repository->findAll(), 'user' => $user]);
    }

    /**
     * @Route("/product/{id}", name="product")
     * @param int $id
     * @return Response
     */
    public function product(int $id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        return $this->render('product.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/product/{id}/edit", name="editProduct")
     * @param int $id
     * @return Response
     */
    public function editProduct(int $id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($id);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('editProduct', ['id' => $id]);
        }

        return $this->render('form', [
            'form' => $form->createView()
        ]);
    }

    private function getActiveUser(): ?User
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        return $repository->getTargetUser();
    }
}

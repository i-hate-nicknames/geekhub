<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Forms\ProductType;
use App\Services\Store;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function var_export;

class StoreController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Store $store
     * @return Response
     * @throws \Exception
     */
    public function hello(Store $store)
    {
        return $this->render('categories.html.twig', ['categories' => $store->getProductsGroupedByCategory()]);
    }

    /**
     * @Route("/form")
     */
    public function form(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        $repository = $this->getDoctrine()->getRepository(User::class);

        $user = $repository->findOneBy(['name' => 'user1']);
        $product->setUser($user);


        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('form', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/createProduct/{name}/{price}/{qty}/{description}")
     * @param Store $store
     * @param $name
     * @param int $price
     * @param int $qty
     * @param string $description
     * @return Response
     */
    public function createProduct(Store $store, $name, $price = 0, $qty = 0, $description = '')
    {
        $store->createProduct($name, $qty, $price, $description);
        return $this->redirect('/');
    }

    /**
     * @Route("/moveProduct/{productId}/{target}")
     * @param $productId
     * @param $target
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function moveProduct(Store $store, $productId, $target)
    {
        $store->move($productId, $target);
        return $this->redirect('/');
    }

    /**
     * @Route("/createCategory/{name}")
     * @param Store $store
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createCategory(Store $store, string $name)
    {
        $store->createCategory($name);
        return $this->redirect('/');
    }
}

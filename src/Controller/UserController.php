<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use App\Forms\ProductType;
use App\Forms\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     * @return Response
     * @throws \Exception
     */
    public function users()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $activeUser = $this->getActiveUser();
        return $this->render('users.html.twig', ['users' => $repository->findAll(), 'activeUser' => $activeUser]);
    }

    /**
     * @Route("/user/{id}/edit", name="editUser")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function editUser(int $id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->find($id);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('editUser', ['id' => $user->getId()]);
        }

        return $this->render('form', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/favorites", name="favorites")
     * @return Response
     * @throws \Exception
     */
    public function favorites()
    {
        return $this->render('favorites.html.twig', ['user' => $this->getActiveUser()]);
    }

    /**
     * @Route("/favorites/products/add/{id}", name="favoritesAddProduct")
     * @return Response
     * @throws \Exception
     */
    public function addProduct(int $id)
    {
        $user = $this->getActiveUser();
        if (!$user) {
            $this->addFlash('error', 'Please log in');
            return $this->redirectToRoute('products');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Product::class);
        $product = $repo->find($id);
        if (!$product) {
            $this->addFlash('error', 'Product doesn\'t exist');
            return $this->redirectToRoute('products');
        }
        $user->addProduct($product);
        $entityManager->flush();
        return $this->redirectToRoute('products');
    }

    /**
     * @Route("/favorites/products/remove/{id}", name="favoritesRemoveProduct")
     * @return Response
     * @throws \Exception
     */
    public function removeProduct(int $id, Request $request)
    {
        $referer = $request->headers->get('referer');
        $user = $this->getActiveUser();
        if (!$user) {
            $this->addFlash('error', 'Please log in');
            return new RedirectResponse($referer);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Product::class);
        $product = $repo->find($id);
        if (!$product) {
            $this->addFlash('error', 'Product doesn\'t exist');
            return new RedirectResponse($referer);
        }
        if (!$user->hasProduct($product)) {
            $this->addFlash('error', 'This product is not in your favorite list');
            return new RedirectResponse($referer);
        }
        $user->removeProduct($product);
        $entityManager->flush();
        return new RedirectResponse($referer);
    }

    /**
     * @Route("/favorites/users/add/{id}", name="favoritesAddUser")
     * @return Response
     * @throws \Exception
     */
    public function addFavoriteUser(int $id)
    {
        $user = $this->getActiveUser();
        if (!$user) {
            $this->addFlash('error', 'Please log in');
            return $this->redirectToRoute('products');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(User::class);
        $fav = $repo->find($id);
        if (!$fav) {
            $this->addFlash('error', 'User doesn\'t exist');
            return $this->redirectToRoute('users');
        }
        $user->addFavoriteUser($fav);
        $entityManager->flush();
        return $this->redirectToRoute('users');
    }

    /**
     * @Route("/favorites/users/remove/{id}", name="favoritesRemoveUser")
     * @return Response
     * @throws \Exception
     */
    public function removeFavoriteUser(int $id, Request $request)
    {
        $referer = $request->headers->get('referer');
        $user = $this->getActiveUser();
        if (!$user) {
            $this->addFlash('error', 'Please log in');
            return new RedirectResponse($referer);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(User::class);
        $fav = $repo->find($id);
        if (!$fav) {
            $this->addFlash('error', 'User doesn\'t exist');
            return new RedirectResponse($referer);
        }
        if (!$user->hasFavoriteUser($fav)) {
            $this->addFlash('error', 'This user is not in your favorite list');
            return new RedirectResponse($referer);
        }
        $user->removeFavoriteUser($fav);
        $entityManager->flush();
        return new RedirectResponse($referer);
    }

    // todo: move this somewhere common to controllers?
    private function getActiveUser(): ?User
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        return $repository->getTargetUser();
    }
}

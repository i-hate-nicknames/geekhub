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
        return $this->render('users.html.twig', ['users' => $repository->findAll()]);
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

    private function getActiveUser(): ?User
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        return $repository->getTargetUser();
    }
}

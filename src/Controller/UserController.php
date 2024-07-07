<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/users')]
class UserController extends AbstractController
{
    //получает лист всех пользователей
    #[Route('/', name: 'users_list', methods: ['GET'])]
    public function usersList(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    // ищет и возвращает одного пользователя по id
    #[Route('/{id}', name: 'user_get', methods: ['GET'])]
    public function findUser(string $id): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    // удаление пользователя
    #[Route('/delete/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function deleteUser(string $id): Response
    {
//        $em = $this->getDoctrine()->getManager();
//        $user = $em->getRepository(User::class)->find($id);
//
//        if (!$user) {
//            throw $this->createNotFoundException(
//                'No user found for id '.$id
//            );
//        }
//
//        $em->remove($user);
//        $em->flush();

        return new Response('User deleted');
    }
    #[Route('/change/{id}', name: 'user_change', methods: ['PUT'])]
    public function changeUser (string $id): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/edit/{id}', name: 'user_edit', methods: ['PATCH'])]
    public function editUser (string $id): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/', name: 'user_create', methods: ['POST'])]
    public function createUser(Request $request): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    #[Route('/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function deleteUser(string $id, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(User::class);

        $user = $repository->find($id);

        if ($user) {
            $entityManager->remove($user);
            $entityManager->flush();

            return new Response('User deleted');
        }

        throw $this->createNotFoundException(
            'No user found for id '.$id
        );
    }
    #[Route('/{id}', name: 'user_change', methods: ['PUT'])]
    public function changeUser(string $id, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $repository = $entityManager->getRepository(User::class);
        $user = $repository->find($id);
        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $data = json_decode($request->getContent(), true);

        if(isset($data['name'])){
            $user->setName($data['name']);
        }
        if(isset($data['surname'])){
            $user->setSurname($data['surname']);
        }
        if(isset($data['email'])){
            $user->setEmail($data['email']);
        }

        $entityManager->flush();

        return new JsonResponse(['status' => 'User updated'], Response::HTTP_OK);
    }

    #[Route('/', name: 'user_create', methods: ['POST'])]
    public function createUser(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name']) || !isset($data['surname']) || !isset($data['email'])) {
            return new JsonResponse(['error' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
        }

        $user = new User();
        $user->setName($data['name']);
        $user->setSurname($data['surname']);
        $user->setEmail($data['email']);

        $em->persist($user);
        $em->flush();

        return new JsonResponse(['status' => 'User created'], Response::HTTP_CREATED);
    }
}

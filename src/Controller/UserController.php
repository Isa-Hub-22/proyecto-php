<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\UserType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/create/user', name: 'createUser')]

    public function insertUser(Request $request, EntityManagerInterface $doctrine, UserPasswordHasherInterface $hasher){

        $form = $this->createForm(UserType::class);
        $form-> handleRequest($request);
        if ($form-> isSubmitted() && $form-> isValid()){
            $user=$form->getData();
            $password = $user -> getPassword();
            $cifrado = $hasher -> hashPassword($user, $password);
            $user -> setPassword($cifrado);
            $doctrine-> persist($user);
            $doctrine-> flush();
            $this->addFlash('success', 'Usuario insertado correctamente');
            return $this-> redirectToRoute('listRickAndMorty');
        }
        return $this->renderForm('user/createUser.html.twig', [
            'userForm' => $form
        ]);
    }

    #[Route('/create/admin', name: 'createAdmin')]

    public function insertAdmin(Request $request, EntityManagerInterface $doctrine, UserPasswordHasherInterface $hasher){

        $form = $this->createForm(UserType::class);
        $form-> handleRequest($request);
        if ($form-> isSubmitted() && $form-> isValid()){
            $user=$form->getData();
            $password = $user -> getPassword();
            $cifrado = $hasher -> hashPassword($user, $password);
            $user -> setPassword($cifrado);
            $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);       
            $doctrine-> persist($user);
            $doctrine-> flush();
            $this->addFlash('success', 'Usuario insertado correctamente');
            return $this-> redirectToRoute('listRickAndMorty');
        }
        return $this->renderForm('user/createUser.html.twig', [
            'userForm' => $form
        ]);
    }
}
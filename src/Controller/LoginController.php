<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\InMemoryUser;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(
        AuthenticationUtils $authenticationUtils,
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
    ): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $ultimoUsuario = $authenticationUtils->getLastUsername();
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);
        // $senha = $userPasswordHasher->hashPassword(
        //     new InMemoryUser('thiago', 'thiago'),
        //     'thiago'
        // );

        return $this->render(
            'login/login.html.twig', 
            compact(
                'form', 
                'error', 
                'ultimoUsuario', 
                // 'senha'
            ),
        );
    }
}

<?php

namespace App\Controller;

use App\Entity\Visiteur;
use App\Service\JwtTokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('auth')]
class AuthController extends AbstractController
{
    private JwtTokenGenerator $tokenGenerator;
    private EntityManagerInterface $entityManager;

    public function __construct(JwtTokenGenerator $tokenGenerator, EntityManagerInterface $entityManager)
    {
        $this->tokenGenerator = $tokenGenerator;
        $this->entityManager = $entityManager;
    }


    #[Route('/login', name: 'auth_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $login = json_decode($request->getContent())->login;
        $password = json_decode($request->getContent())->password;
        $visitor = $this->entityManager->getRepository(Visiteur::class)->findByVisitorByLoginAndPassword($login, $password);
        if (is_null($visitor)) {
            return new JsonResponse(["data" => "Login ou mot de passe incorrecte"], 400);
        }
        $token = $this->tokenGenerator->generateToken(["id" => $visitor->getId(),
             "login" => $visitor->getLogin()]);
        $response = [
            "data" => $token
        ];
        return new JsonResponse($response, 200);
    }
}
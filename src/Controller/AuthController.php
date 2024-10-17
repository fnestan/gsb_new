<?php

namespace App\Controller;

use App\Entity\Visiteur;
use App\Service\JwtTokenGenerator;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Random\RandomException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
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
            return new JsonResponse(["error" => "Login ou mot de passe incorrecte"], 400);
        }
        $token = $this->tokenGenerator->generateToken(["id" => $visitor->getId(),
            "login" => $visitor->getLogin()]);
        $response = [
            "data" => $token
        ];
        return new JsonResponse($response, 200);
    }

    #[Route('/logout', name: 'auth_logout', methods: ['GET'])]
    public function logout(Request $request)
    {
        $authorizationHeader = $request->headers->get('Authorization');

        if (!$authorizationHeader || !str_starts_with($authorizationHeader, 'Bearer ')) {
            return new JsonResponse(['error' => 'Token manquant ou incorrect'], 401);
        }
        $token = str_replace('Bearer ', '', $authorizationHeader);
        $tokenIsValid = $this->tokenGenerator->validateToken($token);
        $visiteurId = $this->tokenGenerator->getClaims($token)["uid"];
        $visitorRepository = $this->entityManager->getRepository(Visiteur::class);
        $visitor = $visitorRepository->find($visiteurId);
        if (is_null($visitor) || !$tokenIsValid) {
            return new JsonResponse(['error' => 'Token manquant ou incorrect ou visiteur inexistant'], 401);
        }
        $this->tokenGenerator->addToBlacklist($token);
        return new JsonResponse([], 204);
    }
}
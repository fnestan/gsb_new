<?php

namespace App\Service;

use DateTimeImmutable;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\ValidAt;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class JwtTokenGenerator
{
    private string $secret;
    private Configuration $config;


    public function __construct(ParameterBagInterface $params)
    {
        $this->secret = $params->get('JWT_SECRET');
        $this->config = Configuration::forSymmetricSigner(
            new Sha256(),
            \Lcobucci\JWT\Signer\Key\InMemory::plainText($this->secret)
        );
    }

    public function generateToken(array $data): string
    {

        $now = new \DateTimeImmutable();

        $token = $this->config->builder()
            ->issuedBy('http://your-website.com')
            ->issuedAt($now)
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('uid', $data['id'])
            ->withClaim('login', $data['login'])
            ->getToken($this->config->signer(), $this->config->signingKey()); // Signature

        return $token->toString();
    }

    public function validateToken(string $tokenString): bool
    {
        $token = $this->config->parser()->parse($tokenString);

        // Contrainte de validation : vérification de la signature et de l'expiration
        $constraints = [
            new SignedWith($this->config->signer(), $this->config->signingKey())
        ];

        $edded = $this->config->validator()->validate($token, ...$constraints);

        var_dump($edded);
        die();
        $claims = $token->claims();

        if ($claims->has('exp')) {
            $expiration = $claims->get('exp');
            return $expiration > new DateTimeImmutable();
        } else {
            return false;
        }
    }

    public function getClaims(string $tokenString): array
    {
        $token = $this->config->parser()->parse($tokenString);

        return $token->claims()->all();
    }
}
<?php

namespace App\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpFoundation\Request;

class JWTService
{
    private string $key;

    public function __construct()
    {
        $this->key = $_ENV['JWT_SECRET'];
    }

    public function encode(array $payload): string
    {
        return JWT::encode($payload, $this->key, 'HS256');
    }

    public function decode(string $jwt): array
    {
        return (array) JWT::decode($jwt, new Key($this->key, 'HS256'));
    }

    public function getUserId(Request $request): int
    {
        $authHeader = $request->headers->get('Authorization');

        $token = explode(' ', $authHeader);

        return $this->decode($token[1])['id'];
    }

    public function getUserEmail(Request $request): string
    {
        $authHeader = $request->headers->get('Authorization');

        $token = explode('Bearer ', $authHeader[0]);

        return $this->decode($token[1])['email'];
    }
}
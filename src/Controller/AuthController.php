<?php

namespace App\Controller;

use App\DTO\LoginDTO;
use App\DTO\RegisterDTO;
use App\Service\JWTService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use App\Service\AuthService;

#[OA\Tag('Authentication')]
class AuthController extends AbstractController
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly JWTService  $jwtService
    )
    {}

    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "fullName", type: "string", example: "Jane Doe"),
                new OA\Property(property: "dateOfBirth", type: "string", format: "date", example: "2023-01-01"),
                new OA\Property(property: "email", type: "string", example: "example@email.com"),
                new OA\Property(property: "password", type: "string", example: "123456"),
                new OA\Property(property: "passwordConfirmation", type: "string", example: "123456"),
            ],
            type: "object"
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Returns the registered user",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "id", type: "number", example: "1"),
                new OA\Property(property: "fullName", type: "string", example: "Jane Doe"),
                new OA\Property(property: "dateOfBirth", type: "string", format: "date", example: "2023-01-01"),
                new OA\Property(property: "email", type: "string", example: "example@email.com"),
                new OA\Property(property: "token", type: "string", example: "string"),
            ],
            type: 'object'
        ),
    )]
    public function register(Request $request, RegisterDTO $registerDTO): Response
    {
        $registerDTO->fromRequest($request);
        $registerDTO->validate();

        $user = ($this->authService->register($registerDTO))->toArray();

        $token = $this->jwtService->encode([
            'id' => $user['id'],
            'email' => $user['email'],
            'fullName' => $user['fullName'],
        ]);

        return $this->json([
            ...$user,
            'token' => $token
        ], Response::HTTP_OK);
    }

    #[Route('/api/login', name: 'app_login', methods: ['POST'])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "email", type: "string", example: "example@email.com"),
                new OA\Property(property: "password", type: "string", example: "123456"),
            ],
            type: "object"
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Returns the token for the authenticated user",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "token", type: "string", example: "string"),
            ],
            type: 'object'
        ),
    )]
    #[OA\Response(response: 409, description: "Invalid credentials")]
    public function login(Request $request, LoginDTO $loginDTO): Response
    {
        $loginDTO->fromRequest($request);
        $loginDTO->validate();

        $token = $this->authService->login($loginDTO);

        return $this->json(['token' => $token], Response::HTTP_OK);
    }
}

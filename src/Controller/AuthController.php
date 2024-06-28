<?php

namespace App\Controller;

use App\DTO\RegisterDTO;
use App\Service\JWTService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use App\Service\RegisterService;

#[OA\Tag('Authentication')]
class AuthController extends AbstractController
{
    public function __construct(
        private readonly RegisterService $service,
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
        description: "Returns the rewards of an user",
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

        $user = ($this->service->register($registerDTO))->toArray();
        $jwt = $this->jwtService->encode($user);

        return $this->json([
            ...$user,
            'token' => $jwt
        ], Response::HTTP_OK);
    }
}

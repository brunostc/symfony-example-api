<?php

namespace App\Controller;

use App\DTO\BookDTO;
use App\Interfaces\JWTAuthenticatedControllerInterface as JWTAuthenticatedController;
use App\Service\BookService;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[OA\Tag('Books')]
#[Security(name: 'Bearer')]
class BookController extends AbstractController implements JWTAuthenticatedController
{
    public function __construct(
        public BookService $service
    )
    {}

    #[Route('/api/books/{id}', methods: ['GET'], format: 'json')]
    #[OA\Response(
        response: 200,
        description: "Returns the book requested",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "title", type: "string", example: "Title"),
                new OA\Property(property: "description", type: "string", example: "Description"),
                new OA\Property(property: "author", type: "string", example: "John Doe"),
                new OA\Property(property: "publishingDate", type: "string", format: "date", example: "2023-01-01"),
                new OA\Property(property: "coAuthor", type: "string", example: "Jane Doe", nullable: true),
                new OA\Property(property: "createdAt", type: "string", format: "datetime", example: "2024-06-28 14:30:59.000"),
                new OA\Property(property: "updatedAt", type: "string", format: "datetime", example: "2024-06-28 14:30:59.000"),
            ],
            type: 'object'
        )
    )]
    public function get(int $id): Response
    {
        $book = $this->service->find($id);

        if (!$book) {
            return $this->json([
                'message' => 'Book not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return $this->json($book, Response::HTTP_OK);
    }

    #[Route('/api/books', methods: ['GET'], format: 'json')]
    #[OA\QueryParameter(name: 'page', schema: new OA\Schema(type: 'integer'))]
    #[OA\QueryParameter(name: 'limit', schema: new OA\Schema(type: 'integer'))]
    public function list(Request $request): Response
    {
        $books = $this->service->list(
            page: $request->query->get('page', 1),
            limit: $request->query->get('limit', 10)
        );

        return $this->json($books);
    }

    #[Route('/api/books', methods: ['POST'], format: 'json')]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "title", type: "string", example: "Title"),
                new OA\Property(property: "description", type: "string", example: "Description"),
                new OA\Property(property: "author", type: "string", example: "John Doe"),
                new OA\Property(property: "publishingDate", type: "string", format: "date", example: "2023-01-01"),
                new OA\Property(property: "coAuthor", type: "string", example: "Jane Doe", nullable: true)
            ],
            type: "object"
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Returns the book created",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "title", type: "string", example: "Title"),
                new OA\Property(property: "description", type: "string", example: "Description"),
                new OA\Property(property: "author", type: "string", example: "John Doe"),
                new OA\Property(property: "publishingDate", type: "string", format: "date", example: "2023-01-01"),
                new OA\Property(property: "coAuthor", type: "string", example: "Jane Doe", nullable: true),
                new OA\Property(property: "createdAt", type: "string", format: "datetime", example: "2024-06-28 14:30:59.000"),
                new OA\Property(property: "updatedAt", type: "string", format: "datetime", example: "2024-06-28 14:30:59.000"),
            ],
            type: 'object'
        )
    )]
    public function create(Request $request, BookDTO $bookDTO): Response
    {
        $bookDTO->fromRequest($request);
        $bookDTO->validate();

        $book = $this->service->create($bookDTO);

        return $this->json($book, Response::HTTP_CREATED);
    }

    #[Route('/api/books/{id}', methods: ['PUT'], format: 'json',)]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "title", type: "string", example: "Title"),
                new OA\Property(property: "description", type: "string", example: "Description"),
                new OA\Property(property: "author", type: "string", example: "John Doe"),
                new OA\Property(property: "publishingDate", type: "string", format: "date", example: "2023-01-01"),
                new OA\Property(property: "coAuthor", type: "string", example: "Jane Doe", nullable: true)
            ],
            type: "object"
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Returns the book updated",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "title", type: "string", example: "Title"),
                new OA\Property(property: "description", type: "string", example: "Description"),
                new OA\Property(property: "author", type: "string", example: "John Doe"),
                new OA\Property(property: "publishingDate", type: "string", format: "date", example: "2023-01-01"),
                new OA\Property(property: "coAuthor", type: "string", example: "Jane Doe", nullable: true),
                new OA\Property(property: "createdAt", type: "string", format: "datetime", example: "2024-06-28 14:30:59.000"),
                new OA\Property(property: "updatedAt", type: "string", format: "datetime", example: "2024-06-28 14:30:59.000"),
            ],
            type: 'object'
        )
    )]
    public function update(int $id, Request $request, BookDTO $bookDTO): Response
    {
        $bookDTO->fromRequest($request);
        $bookDTO->validate();

        $book = $this->service->update($id, $bookDTO);

        if (!$book) {
            return $this->json([
                'message' => 'Book not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return $this->json($book, Response::HTTP_OK);
    }

    #[Route('/api/books/{id}', methods: ['DELETE'], format: 'json')]
    public function delete(int $id): Response
    {
        $book = $this->service->delete($id);

        if (!$book) {
            return $this->json([
                'message' => 'Book not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return $this->json(null, Response::HTTP_OK);
    }
}

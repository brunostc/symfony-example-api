<?php

namespace App\Controller;

use App\DTO\BookDTO;
use App\Service\BookService;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    public BookService $service;

    public function __construct(BookService $service)
    {
        $this->service = $service;
    }

    #[Route('/api/books/{id}', methods: ['GET'], format: 'json')]
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
    public function list(Request $request): Response
    {
        $books = $this->service->list(
            page: $request->query->get('page', 1),
            limit: $request->query->get('limit', 10)
        );

        return $this->json($books);
    }

    #[Route('/api/books', methods: ['POST'], format: 'json')]
    #[OA\Parameter(name: 'title', schema: new OA\Schema(type: 'string'))]
    #[OA\Parameter(name: 'description', schema: new OA\Schema(type: 'string'))]
    #[OA\Parameter(name: 'author', schema: new OA\Schema(type: 'string'))]
    #[OA\Parameter(name: 'publishingDate', schema: new OA\Schema(type: 'date'))]
    #[OA\Parameter(name: 'coAuthor', required: false, schema: new OA\Schema(type: 'string'))]
    public function create(BookDTO $bookDTO): Response
    {
        $bookDTO->validate();

        $book = $this->service->create($bookDTO);

        return $this->json($book, Response::HTTP_CREATED);
    }

    #[Route('/api/books/{id}', methods: ['PUT'], format: 'json')]
    #[OA\Parameter(name: 'title', schema: new OA\Schema(type: 'string'))]
    #[OA\Parameter(name: 'description', schema: new OA\Schema(type: 'string'))]
    #[OA\Parameter(name: 'author', schema: new OA\Schema(type: 'string'))]
    #[OA\Parameter(name: 'publishingDate', schema: new OA\Schema(type: 'date'))]
    #[OA\Parameter(name: 'coAuthor', required: false, schema: new OA\Schema(type: 'string'))]
    public function update(int $id, BookDTO $bookDTO): Response
    {
        $bookDTO->validate();

        $book = $this->service->update($id, $bookDTO);

        if (!$book) {
            return $this->json([
                'message' => 'Book not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return $this->json($book, Response::HTTP_OK);
    }
}

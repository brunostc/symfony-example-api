<?php

namespace App\Controller;
use App\DTO\BookReviewDTO;
use App\Service\BookService;
use App\Service\JWTService;
use App\Service\ReviewService;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;;
use OpenApi\Attributes as OA;

#[OA\Tag('Reviews')]
#[Security(name: 'Bearer')]
class ReviewController extends AbstractController
{
    public function __construct(
        protected JWTService $jwtService,
        protected BookService $bookService,
        protected ReviewService $reviewService
    )
    {
    }

    #[Route('/api/review/book/{bookId}', name: 'get_user_book_reviews', methods: ['GET'], format: 'json')]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: "Returns the books review for this user",
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
            properties: [
                new OA\Property(property: "id", type: "integer", example: "1"),
                new OA\Property(property: "title", type: "string", example: "Title"),
                new OA\Property(property: "description", type: "string", example: "Description"),
                new OA\Property(property: "createdAt", type: "string", format: "datetime", example: "2024-06-28 14:30:59.000"),
                new OA\Property(property: "updatedAt", type: "string", format: "datetime", example: "2024-06-28 14:30:59.000"),
            ])
        )
    )]
    #[OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Book was not found')]
    public function index(int $bookId, Request $request): JsonResponse
    {
        $userId = $this->jwtService->getUserId($request);
        $reviews = $this->reviewService->getUserBookReviews($bookId, $userId);

        return $this->json($reviews, Response::HTTP_OK);
    }

    #[Route('/api/review/book/{bookId}', name: 'create_book_review', methods: ['POST'], format: 'json')]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "title", type: "string", example: "Title"),
                new OA\Property(property: "description", type: "string", example: "Description"),
            ],
            type: "object"
        )
    )]
    #[OA\Response(
        response: Response::HTTP_CREATED,
        description: "Returns the book review created",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "id", type: "integer", example: "1"),
                new OA\Property(property: "title", type: "string", example: "Title"),
                new OA\Property(property: "description", type: "string", example: "Description"),
                new OA\Property(property: "createdAt", type: "string", format: "datetime", example: "2024-06-28 14:30:59.000"),
                new OA\Property(property: "updatedAt", type: "string", format: "datetime", example: "2024-06-28 14:30:59.000"),
            ],
            type: 'object'
        )
    )]
    #[OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Book was not found')]
    public function create(int $bookId, Request $request, BookReviewDTO $bookReviewDTO): JsonResponse
    {
        $userId = $this->jwtService->getUserId($request);

        $bookReviewDTO->fromRequest($request);
        $bookReviewDTO->validate();
        $bookReviewDTO->setBookId($bookId);
        $bookReviewDTO->setUserId($userId);

        $review = $this->reviewService->createReview($bookReviewDTO);

        return $this->json($review, Response::HTTP_CREATED);
    }
}
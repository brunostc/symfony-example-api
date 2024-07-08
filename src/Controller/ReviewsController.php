<?php

namespace App\Controller;
use App\DTO\BookReviewDTO;
use App\Service\JWTService;
use App\Service\ReviewService;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;;
use OpenApi\Attributes as OA;

#[OA\Tag('Reviews')]
#[Security(name: 'Bearer')]
class ReviewsController extends AbstractController
{
    public function __construct(
        protected JWTService $jwtService,
        protected ReviewService $reviewService
    )
    {
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
    public function create(int $bookId, Request $request, BookReviewDTO $bookReviewDTO): JsonResponse
    {
        $userId = $this->jwtService->getUserId($request);

        $bookReviewDTO->fromRequest($request);
        $bookReviewDTO->validate();
        $bookReviewDTO->setBookId($bookId);
        $bookReviewDTO->setUserId($userId);

        $review = $this->reviewService->createReview($bookReviewDTO);

        return $this->json($review, 201);
    }
}
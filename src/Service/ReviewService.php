<?php

namespace App\Service;

use App\DTO\BookReviewDTO;
use App\Entity\Review;
use App\Repository\BookRepository;
use App\Repository\ReviewRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReviewService
{
    public function __construct(
        protected ReviewRepository $reviewRepository,
        protected UserRepository $userRepository,
        protected BookRepository $bookRepository,
    )
    {
    }

    public function createReview(BookReviewDTO $bookReviewDTO): Review
    {
        $book = $this->bookRepository->find($bookReviewDTO->getBookId());

        if (!$book) {
            throw new NotFoundHttpException('Book not found');
        }

        $user = $this->userRepository->find($bookReviewDTO->getUserId());

        return $this->reviewRepository->create($bookReviewDTO, $book, $user);
    }

    public function getUserBookReviews(int $bookId, int $userId): array
    {
        $book = $this->bookRepository->find($bookId);

        if (!$book) {
            throw new NotFoundHttpException('Book not found');
        }

        return $this->reviewRepository->findBy(['book' => $bookId, 'reviewer' => $userId]);
    }
}
<?php

namespace App\Service;

use App\DTO\BookReviewDTO;
use App\Entity\Review;
use App\Repository\BookRepository;
use App\Repository\ReviewRepository;
use App\Repository\UserRepository;

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
        $user = $this->userRepository->find($bookReviewDTO->getUserId());
        $book = $this->bookRepository->find($bookReviewDTO->getBookId());
        return $this->reviewRepository->create($bookReviewDTO, $book, $user);
    }
}
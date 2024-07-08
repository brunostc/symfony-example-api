<?php

namespace App\Repository;

use App\DTO\BookReviewDTO;
use App\Entity\Book;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function create(BookReviewDTO $bookReviewDTO, Book $book, User $user): Review
    {
        $review = new Review();
        $review->setReviewer($user);
        $review->setBook($book);
        $review->setTitle($bookReviewDTO->getTitle());
        $review->setDescription($bookReviewDTO->getDescription());
        $this->getEntityManager()->persist($review);
        $this->getEntityManager()->flush();

        return $review;
    }
}

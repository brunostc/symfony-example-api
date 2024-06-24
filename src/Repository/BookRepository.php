<?php

namespace App\Repository;

use DateTime;
use App\DTO\BookDTO;
use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class BookRepository extends ServiceEntityRepository
{
    public EntityManagerInterface $entityManagerInterface;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManagerInterface = $entityManagerInterface;

        parent::__construct($registry, Book::class);
    }

    public function list(int $page, int $limit): array
    {
        $queryBuilder = $this->createQueryBuilder('b');

        return [
            'data' => $queryBuilder
                ->setFirstResult($limit * ($page - 1))
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult(),
            'limit' => $limit,
            'page' => $page
        ];
    }

    public function create(BookDTO $bookDTO): Book
    {
        $book = new Book();

        $book->setTitle($bookDTO->getTitle());
        $book->setDescription($bookDTO->getDescription());
        $book->setAuthor($bookDTO->getAuthor());
        $book->setPublishingDate(new DateTime($bookDTO->getPublishingDate()));
        $book->setCoAuthor($bookDTO->getCoAuthor());

        $this->entityManagerInterface->persist($book);
        $this->entityManagerInterface->flush();

        return $book;
    }

    public function update(Book $book, BookDTO $bookDTO): Book
    {
        $book->setTitle($bookDTO->getTitle());
        $book->setDescription($bookDTO->getDescription());
        $book->setAuthor($bookDTO->getAuthor());
        $book->setPublishingDate(new DateTime($bookDTO->getPublishingDate()));
        $book->setCoAuthor($bookDTO->getCoAuthor());
        $this->entityManagerInterface->persist($book);
        $this->entityManagerInterface->flush();
        return $book;
    }

    public function delete(Book $book): void
    {
        $this->entityManagerInterface->remove($book);
        $this->entityManagerInterface->flush();
    }
}

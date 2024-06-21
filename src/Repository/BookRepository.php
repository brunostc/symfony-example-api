<?php

namespace App\Repository;

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

    public function list(int $page, int $limit)
    {
        $queryBuilder = $this->createQueryBuilder('b');

        return $queryBuilder 
        ->setFirstResult($limit * ($page - 1))
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
    }

    public function create(BookDTO $bookDTO): Book
    {
        $book = new Book();
        
        $book->setTitle($book->getTitle());
        $book->setDescription($book->getDescription());
        $book->setAuthor($book->getAuthor());
        $book->setPublishingDate($book->getPublishingDate());
        $book->setCoAuthor($book->getCoAuthor());

        $this->entityManagerInterface->persist($book);
        $this->entityManagerInterface->flush();

        return $book;
    }
}

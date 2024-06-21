<?php

namespace App\Service;

use App\DTO\BookDTO;
use App\Entity\Book;
use App\Repository\BookRepository;

class BookService
{
    public BookRepository $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list(int $page, int $limit)
    {
        return $this->repository->list($page, $limit);
    }

    public function create(BookDTO $bookDTO): Book
    {
        return $this->repository->create($bookDTO);
    }
}

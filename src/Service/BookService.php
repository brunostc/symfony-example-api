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

    public function find(int $id): Book|null
    {
        return $this->repository->find($id);
    }

    public function list(int $page, int $limit): array
    {
        return $this->repository->list($page, $limit);
    }

    public function create(BookDTO $bookDTO): Book
    {
        return $this->repository->create($bookDTO);
    }

    public function update(int $id, BookDTO $bookDTO): Book|null
    {
        /** @var Book $book */
        $book = $this->repository->find($id);

        if (!$book) {
            return null;
        }

        return $this->repository->update($book, $bookDTO);
    }
}

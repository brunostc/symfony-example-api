<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class BookDTO extends BaseDTO
{
    #[Type('string')]
    #[NotBlank()]
    protected string $title;

    #[Type('string')]
    #[NotBlank()]
    protected string $author;

    #[Type('string')]
    #[NotBlank()]
    protected string $description;

    #[Type('string')]
    #[NotBlank()]
    protected string $publishingDate;

    #[Type('string')]
    protected ?string $coAuthor;

    public function getData(): array
    {
        return [
            'title' => $this->getTitle(),
            'author' => $this->getAuthor(),
            'description' => $this->getDescription(),
            'publishing_date' => $this->getPublishingDate(),
            'co_author' => $this->getCoAuthor(),
        ];
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPublishingDate(): string
    {
        return $this->publishingDate;
    }

    public function setPublishingDate(string $publishingDate): void
    {
        $this->publishingDate = $publishingDate;
    }

    public function getCoAuthor(): ?string
    {
        return $this->coAuthor;
    }

    public function setCoAuthor(?string $coAuthor): void
    {
        $this->coAuthor = $coAuthor;
    }
}


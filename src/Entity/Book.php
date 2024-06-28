<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookRepository;
use App\Traits\HasCreatedUpdatedAtColumns;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Book
{
    use HasCreatedUpdatedAtColumns;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coAuthor = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $publishingDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getCoAuthor(): ?string
    {
        return $this->coAuthor;
    }

    public function setCoAuthor(?string $coAuthor): static
    {
        $this->coAuthor = $coAuthor;

        return $this;
    }

    public function getPublishingDate(): ?\DateTimeInterface
    {
        return $this->publishingDate;
    }

    public function setPublishingDate(\DateTimeInterface $publishingDate): static
    {
        $this->publishingDate = $publishingDate;

        return $this;
    }
}

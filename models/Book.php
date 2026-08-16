<?php

class Book
{
    private ?int $idBook;
    private string $title;
    private string $author;
    private string $image;
    private string $description;
    private string $status;
    private ?string $createdAt;
    private ?string $updatedAt;
    private int $idUser;

    public function __construct(
        ?int $idBook = null,
        string $title = '',
        string $author = '',
        string $image = '',
        string $description = '',
        string $status = 'available',
        ?string $createdAt = null,
        ?string $updatedAt = null,
        int $idUser = 0
    ) {
        $this->idBook = $idBook;
        $this->title = $title;
        $this->author = $author;
        $this->image = $image;
        $this->description = $description;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->idUser = $idUser;
    }

    public function getIdBook(): ?int
    {
        return $this->idBook;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function getIdUser(): int
    {
        return $this->idUser;
    }
}
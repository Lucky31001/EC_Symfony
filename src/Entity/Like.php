<?php

namespace App\Entity;

use App\Repository\LikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LikeRepository::class)]
#[ORM\Table(name: '`like`')]
class Like
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'likes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'likes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BookRead $book_read = null;

    #[ORM\Column]
    private ?bool $is_like = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBookRead(): ?BookRead
    {
        return $this->book_read;
    }

    public function setBookRead(?BookRead $book_read): static
    {
        $this->book_read = $book_read;

        return $this;
    }

    public function isLike(): ?bool
    {
        return $this->is_like;
    }

    public function setLike(bool $is_like): static
    {
        $this->is_like = $is_like;

        return $this;
    }
}

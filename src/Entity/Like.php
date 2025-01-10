<?php

namespace App\Entity;

use App\Repository\LikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LikeRepository::class)]
class Like
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: BookRead::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $bookRead;

    #[ORM\Column(type: 'boolean')]
    private $isLike = false;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getBookRead()
    {
        return $this->bookRead;
    }

    public function setBookRead($bookRead): void
    {
        $this->bookRead = $bookRead;
    }

    public function getIsLike()
    {
        return $this->isLike;
    }

    public function setIsLike(): void
    {
        $this->isLike = ! $this->isLike;
    }
}

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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getBookRead()
    {
        return $this->bookRead;
    }

    /**
     * @param mixed $bookRead
     */
    public function setBookRead($bookRead): void
    {
        $this->bookRead = $bookRead;
    }

    /**
     * @return mixed
     */
    public function getIsLike()
    {
        return $this->isLike;
    }

    /**
     * @param mixed $isLike
     */
    public function setIsLike(): void
    {
        $this->isLike = !$this->isLike;
    }

}
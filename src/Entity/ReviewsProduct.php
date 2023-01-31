<?php

namespace App\Entity;

use App\Repository\ReviewsProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewsProductRepository::class)]
class ReviewsProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'reviewsProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userReview = null;

    #[ORM\ManyToOne(inversedBy: 'reviewsProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $productReviews = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getUserReview(): ?User
    {
        return $this->userReview;
    }

    public function setUserReview(?User $userReview): self
    {
        $this->userReview = $userReview;

        return $this;
    }

    public function getProductReviews(): ?Product
    {
        return $this->productReviews;
    }

    public function setProductReviews(?Product $productReviews): self
    {
        $this->productReviews = $productReviews;

        return $this;
    }
}

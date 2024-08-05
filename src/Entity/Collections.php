<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CollectionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CollectionsRepository::class)]
#[ApiResource]
class Collections
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $budgetCollection = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDateCollection = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endDateCollection = null;

    #[ORM\Column]
    private ?bool $del = null;

    #[ORM\Column(length: 255)]
    private ?string $nomCollection = null;

    #[ORM\Column(length: 255)]
    private ?string $photoCollection = null;

    #[ORM\ManyToOne(inversedBy: 'collections')]
    private ?User $userCollections = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBudgetCollection(): ?float
    {
        return $this->budgetCollection;
    }

    public function setBudgetCollection(float $budgetCollection): static
    {
        $this->budgetCollection = $budgetCollection;

        return $this;
    }

    public function getStartDateCollection(): ?\DateTimeInterface
    {
        return $this->startDateCollection;
    }

    public function setStartDateCollection(\DateTimeInterface $startDateCollection): static
    {
        $this->startDateCollection = $startDateCollection;

        return $this;
    }

    public function getEndDateCollection(): ?\DateTimeInterface
    {
        return $this->endDateCollection;
    }

    public function setEndDateCollection(\DateTimeInterface $endDateCollection): static
    {
        $this->endDateCollection = $endDateCollection;

        return $this;
    }

    public function isDel(): ?bool
    {
        return $this->del;
    }

    public function setDel(bool $del): static
    {
        $this->del = $del;

        return $this;
    }

    public function getNomCollection(): ?string
    {
        return $this->nomCollection;
    }

    public function setNomCollection(string $nomCollection): static
    {
        $this->nomCollection = $nomCollection;

        return $this;
    }

    public function getPhotoCollection(): ?string
    {
        return $this->photoCollection;
    }

    public function setPhotoCollection(string $photoCollection): static
    {
        $this->photoCollection = $photoCollection;

        return $this;
    }

    public function getUserCollections(): ?User
    {
        return $this->userCollections;
    }

    public function setUserCollections(?User $userCollections): static
    {
        $this->userCollections = $userCollections;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'userAdress', targetEntity: Adress::class)]
    private Collection $adresses;

    #[ORM\OneToMany(mappedBy: 'userReview', targetEntity: ReviewsProduct::class)]
    private Collection $reviewsProducts;

    #[ORM\OneToMany(mappedBy: 'userOrder', targetEntity: Order::class)]
    private Collection $orders;

    public function __construct()
    {
        $this->adresses = new ArrayCollection();
        $this->reviewsProducts = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getFullName(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }
    
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Adress>
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(Adress $adress): self
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses->add($adress);
            $adress->setUserAdress($this);
        }

        return $this;
    }

    public function removeAdress(Adress $adress): self
    {
        if ($this->adresses->removeElement($adress)) {
            // set the owning side to null (unless already changed)
            if ($adress->getUserAdress() === $this) {
                $adress->setUserAdress(null);
            }
        }

        return $this;
    }

//     public function __toString(): string
// {
//     return $this->getUsername();  // or some string field in your Vegetal Entity 
// }

/**
 * @return Collection<int, ReviewsProduct>
 */
public function getReviewsProducts(): Collection
{
    return $this->reviewsProducts;
}

public function addReviewsProduct(ReviewsProduct $reviewsProduct): self
{
    if (!$this->reviewsProducts->contains($reviewsProduct)) {
        $this->reviewsProducts->add($reviewsProduct);
        $reviewsProduct->setUserReview($this);
    }

    return $this;
}

public function removeReviewsProduct(ReviewsProduct $reviewsProduct): self
{
    if ($this->reviewsProducts->removeElement($reviewsProduct)) {
        // set the owning side to null (unless already changed)
        if ($reviewsProduct->getUserReview() === $this) {
            $reviewsProduct->setUserReview(null);
        }
    }

    return $this;
}

/**
 * @return Collection<int, Order>
 */
public function getOrders(): Collection
{
    return $this->orders;
}

public function addOrder(Order $order): self
{
    if (!$this->orders->contains($order)) {
        $this->orders->add($order);
        $order->setUserOrder($this);
    }

    return $this;
}

public function removeOrder(Order $order): self
{
    if ($this->orders->removeElement($order)) {
        // set the owning side to null (unless already changed)
        if ($order->getUserOrder() === $this) {
            $order->setUserOrder(null);
        }
    }

    return $this;
}
}

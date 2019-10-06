<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $booking_date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $booking_description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status_completed;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $price_factor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $category_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $session;    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookingDate(): ?string
    {
        return $this->booking_date;
    }

    public function setBookingDate(?string $booking_date): self
    {
        $this->booking_date = $booking_date;

        return $this;
    }

    public function getBookingDescription(): ?string
    {
        return $this->booking_description;
    }

    public function setBookingDescription(?string $booking_description): self
    {
        $this->booking_description = $booking_description;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStatusCompleted(): ?int
    {
        return $this->status_completed;
    }

    public function setStatusCompleted(?int $status_completed): self
    {
        $this->status_completed = $status_completed;

        return $this;
    }

    public function getPriceFactor(): ?int
    {
        return $this->price_factor;
    }

    public function setPriceFactor(?int $price_factor): self
    {
        $this->price_factor = $price_factor;

        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function setCategoryId(?int $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getSession(): ?string
    {
        return $this->session;
    }

    public function setSession(?string $session): self
    {
        $this->session = $session;

        return $this;
    }    
}

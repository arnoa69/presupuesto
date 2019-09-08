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
     * @ORM\Column(type="datetime", nullable=true)
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
     * @ORM\Column(type="boolean")
     */
    private $status_completed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookingDate(): ?\DateTimeInterface
    {
        return $this->booking_date;
    }

    public function setBookingDate(?\DateTimeInterface $booking_date): self
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

    public function getStatusCompleted(): ?bool
    {
        return $this->status_completed;
    }

    public function setStatusCompleted(bool $status_completed): self
    {
        $this->status_completed = $status_completed;

        return $this;
    }
}

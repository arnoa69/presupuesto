<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
    private $category_name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parent_category;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $category_price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->category_name;
    }

    public function setCategoryName(string $category_name): self
    {
        $this->category_name = $category_name;

        return $this;
    }

    public function getParentCategory(): ?int
    {
        return $this->parent_category;
    }

    public function setParentCategory(?int $parent_category): self
    {
        $this->parent_category = $parent_category;

        return $this;
    }

    public function getCategoryPrice(): ?float
    {
        return $this->category_price;
    }

    public function setCategoryPrice(?float $category_price): self
    {
        $this->category_price = $category_price;

        return $this;
    }
}

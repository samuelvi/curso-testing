<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class ProductEntity
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    protected string $name = '';

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=false)
     */
    protected float $price = 0;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected string $description = '';

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoryEntity", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     */
    protected ?CategoryEntity $category;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected \DateTime $createdAt;

    /**
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    protected bool $enabled = false;

    /**
     * @ORM\Column(name="displatable", type="boolean", nullable=false)
     */
    protected bool $displayable = false;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function setName(?string $name)
    {
        $this->name = $name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    public function getDescription() : ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description)
    {
        $this->description = $description;
    }

    public function getCategory() : ?CategoryEntity
    {
        return $this->category;
    }

    public function setCategory(?CategoryEntity $category)
    {
        $this->category = $category;
    }

    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled($enabled): void
    {
        $this->enabled = $enabled;
    }

    public function isDisplayable(): bool
    {
        return $this->displayable;
    }

    public function setDisplayable(bool $displayable): void
    {
        $this->displayable = $displayable;
    }
}

<?php

declare(strict_types=1);

namespace App\Context\Frontend\Product\Model;

final class RequestModel
{
    public const MAX_PER_PAGE = 10;

    private ?int $categoryId = null;
    private ?int $page       = null;

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(?int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPage(?int $page): void
    {
        $this->page = $page;
    }
}

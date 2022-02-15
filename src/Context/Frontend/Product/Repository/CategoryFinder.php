<?php

declare(strict_types=1);

namespace App\Context\Frontend\Product\Repository;

use App\Entity\CategoryEntity;
use Doctrine\ORM\EntityManagerInterface;

final class CategoryFinder
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findAllCategories(): array
    {
        return $this->em->getRepository(CategoryEntity::class)->createQueryBuilder('category')->getQuery()->getResult();
    }
}

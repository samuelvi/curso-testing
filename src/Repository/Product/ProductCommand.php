<?php

declare(strict_types=1);

namespace App\Repository\Product;

use App\Entity\ProductEntity;
use App\Repository\Product\Resolver\IsDisplayableResolver;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ProductCommand extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductEntity::class);
    }

    public function save(ProductEntity $productEntity)
    {
        $productEntity->setDisplayable(IsDisplayableResolver::resolve($productEntity));
        $this->getEntityManager()->persist($productEntity);
        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();
    }
}

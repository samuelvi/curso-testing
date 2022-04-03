<?php

declare(strict_types=1);

namespace App\Repository\Product;

use App\Entity\ProductEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ProductQuery extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductEntity::class);
    }

    public function findLastInsertedProduct(): ?ProductEntity
    {
        return $this->getEntityManager()
             ->getRepository(ProductEntity::class)
             ->createQueryBuilder('product')
            ->orderBy('product.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

<?php

declare(strict_types=1);

namespace App\Context\Frontend\Product\Repository;

use App\Context\Frontend\Product\Model\RequestModel;
use App\Repository\Product\ProductQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

final class ProductFinder
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findProducts(RequestModel $requestModel): Pagerfanta
    {
        $qb = ProductQuery::buildDisplayableProductsQb($this->em);
        $qb->innerJoin('product.category', 'category')
            ->addSelect('category');

        $this->buildConditions($qb, $requestModel);
        $qb->getQuery()->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);

        $adapter = new QueryAdapter($qb, false);
        $pagerFanta = new Pagerfanta($adapter);

        $pagerFanta->setMaxPerPage(RequestModel::MAX_PER_PAGE);
        $pagerFanta->setCurrentPage($requestModel->getPage());

        return $pagerFanta;
    }

    private function buildConditions(QueryBuilder $qb, RequestModel $requestModel): void
    {
        if ($requestModel->getCategoryId() > 0) {
            $qb->andWhere('category.id = :category_id');
            $qb->setParameter('category_id', $requestModel->getCategoryId());
        }
    }
}

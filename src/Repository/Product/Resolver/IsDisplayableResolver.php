<?php declare(strict_types=1);

namespace App\Repository\Product\Resolver;

use App\Entity\ProductEntity;

final class IsDisplayableResolver
{
    public static function resolve(ProductEntity $productEntity): bool
    {
        if (!$productEntity->isEnabled()) {
            return false;
        }

        if ($productEntity->getPrice() <=0) {
            return false;
        }

        if (empty($productEntity->getName())) {
            return false;
        }

        if (empty($productEntity->getDescription())) {
            return false;
        }

        if (empty($productEntity->getCategory())) {
            return false;
        }

        return true;
    }
}

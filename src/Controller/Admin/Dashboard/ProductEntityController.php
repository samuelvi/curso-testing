<?php
declare(strict_types=1);

namespace App\Controller\Admin\Dashboard;

use App\Controller\Admin\Dashboard\Base\AbstractCrudControllerTrait;
use App\Entity\ProductEntity;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/products")
 */
final class ProductEntityController extends AbstractCrudController
{
    use AbstractCrudControllerTrait;

    public static function getEntityFqcn(): string
    {
        return ProductEntity::class;
    }
}

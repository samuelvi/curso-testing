<?php

declare(strict_types=1);

namespace App\Controller\Admin\Dashboard;

use App\Controller\Admin\Dashboard\Base\AbstractCrudControllerTrait;
use App\Entity\SubscriptionEntity;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categories")
 */
final class SubscriptionEntityController extends AbstractCrudController
{
    use AbstractCrudControllerTrait;

    public static function getEntityFqcn(): string
    {
        return SubscriptionEntity::class;
    }
}

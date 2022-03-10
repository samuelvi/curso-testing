<?php

declare(strict_types=1);

namespace App\Controller\Admin\Dashboard;

use App\Controller\Admin\Dashboard\Base\AbstractCrudControllerTrait;
use App\Entity\UserEntity;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/users")
 */
final class UserEntityController extends AbstractCrudController
{
    use AbstractCrudControllerTrait;

    public static function getEntityFqcn(): string
    {
        return UserEntity::class;
    }
}

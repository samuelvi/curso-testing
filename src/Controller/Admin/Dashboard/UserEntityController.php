<?php declare(strict_types=1);

namespace App\Controller\Admin\Dashboard;

use App\Entity\UserEntity;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/users")
 */
final class UserEntityController extends AbstractCrudController
{
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public static function getEntityFqcn(): string
    {
        return UserEntity::class;
    }
}

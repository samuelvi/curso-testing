<?php

declare(strict_types=1);

namespace App\Controller\Admin\Dashboard;

use App\Controller\Admin\Dashboard\Base\AbstractCrudControllerTrait;
use App\Entity\ProductEntity;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/products")
 */
final class ProductEntityController extends AbstractCrudController
{
    use AbstractCrudControllerTrait;

//    public function configureActions(Actions $actions): Actions
//    {
//        //return parent::configureActions($actions)->add(Crud::PAGE_INDEX, Action::DETAIL);
//        //return $actions->remove(Crud::PAGE_INDEX, Action::DETAIL);
//    }

    public static function getEntityFqcn(): string
    {
        return ProductEntity::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
}

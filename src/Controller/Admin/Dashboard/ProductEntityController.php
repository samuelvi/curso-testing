<?php

declare(strict_types=1);

namespace App\Controller\Admin\Dashboard;

use App\Controller\Admin\Dashboard\Base\AbstractCrudControllerTrait;
use App\Entity\CategoryEntity;
use App\Entity\ProductEntity;
use App\Repository\Product\Resolver\IsDisplayableResolver;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/products")
 */
final class ProductEntityController extends AbstractCrudController
{
    use AbstractCrudControllerTrait;

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

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
        yield TextField::new('name');
        yield TextEditorField::new('description');
        yield NumberField::new('price');
        yield BooleanField::new('enabled');
        yield BooleanField::new('displayable')->hideOnForm()->renderAsSwitch(false);
        yield AssociationField::new('category')->setQueryBuilder(
            fn(QueryBuilder $queryBuilder) => $queryBuilder->getEntityManager()
                ->getRepository(CategoryEntity::class)
                ->findAll()
        );
    }

}

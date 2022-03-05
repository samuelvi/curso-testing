<?php

declare(strict_types=1);

namespace App\Controller\Admin\Dashboard;

use App\Entity\CategoryEntity;
use App\Entity\ProductEntity;
use App\Entity\SubscriptionEntity;
use App\Entity\UserEntity;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="app_admin_dashboard")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'dashboard_controller_filepath' => (new \ReflectionClass(static::class))->getFileName(),
            'dashboard_controller_class' => (new \ReflectionClass(static::class))->getShortName(),
        ]);
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            //MenuItem::section('Users'),
            MenuItem::linkToCrud('Products', 'fa fa-tags', ProductEntity::class),
            MenuItem::linkToCrud('Categories', 'fa fa-tags', CategoryEntity::class),
            MenuItem::linkToCrud('Subscriptions', 'fa fa-tags', SubscriptionEntity::class),
            MenuItem::linkToCrud('Users', 'fa fa-tags', UserEntity::class),
        ];
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('Dashboard');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
                   ->setPaginatorPageSize(100)
                   ->setDateFormat('medium')
                   ->setTimeFormat('short')
                   ->setNumberFormat('%.2d')
                   ->setTimezone('Europe/Madrid')
                   ->setFormThemes(['@EasyAdmin/crud/form_theme.html.twig'])
        ;
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}

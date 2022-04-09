<?php declare(strict_types=1);

namespace App\Context\Admin\ProductEntity;

use App\Entity\ProductEntity;
use App\Repository\Product\Resolver\IsDisplayableResolver;
use EasyCorp\Bundle\EasyAdminBundle\Event\AbstractLifecycleEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class IsDisplayableStablisher implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['stablishIsDisplayableField'],
            BeforeEntityUpdatedEvent::class => ['stablishIsDisplayableField'],
        ];
    }

    public function stablishIsDisplayableField(AbstractLifecycleEvent $event): void
    {
        /** @var ProductEntity $productEntity */
        if (!(($productEntity = $event->getEntityInstance()) instanceof ProductEntity)) {
            return;
        }

        $productEntity->setDisplayable(IsDisplayableResolver::resolve($productEntity));
    }
}

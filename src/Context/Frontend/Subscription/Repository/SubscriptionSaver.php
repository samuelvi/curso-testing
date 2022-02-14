<?php
declare(strict_types=1);

namespace App\Context\Frontend\Subscription\Repository;

use App\Entity\SubscriptionEntity;
use Doctrine\ORM\EntityManagerInterface;

final class SubscriptionSaver
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(SubscriptionEntity $subscriptionEntity):void
    {
        $this->em->persist($subscriptionEntity);
        $this->em->flush();
    }
}

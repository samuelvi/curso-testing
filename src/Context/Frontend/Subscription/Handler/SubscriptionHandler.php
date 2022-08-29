<?php

declare(strict_types=1);

namespace App\Context\Frontend\Subscription\Handler;

use App\Context\Frontend\Subscription\Notifier\SubscriptionMessage;
use App\Context\Frontend\Subscription\Repository\SubscriptionSaver;
use App\Entity\SubscriptionEntity;
use Symfony\Component\Messenger\MessageBusInterface;

class SubscriptionHandler
{
    private SubscriptionSaver   $subscriptionSaver;
    private MessageBusInterface $bus;

    public function __construct(SubscriptionSaver $subscriptionSaver, MessageBusInterface $bus)
    {
        $this->subscriptionSaver = $subscriptionSaver;
        $this->bus = $bus;
    }

    public function handle(SubscriptionEntity $subscriptionEntity)
    {
        $this->subscriptionSaver->save($subscriptionEntity);

        $this->bus->dispatch(new SubscriptionMessage($subscriptionEntity->getId()));
    }
}

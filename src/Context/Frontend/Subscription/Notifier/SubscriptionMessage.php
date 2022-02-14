<?php

declare(strict_types=1);

namespace App\Context\Frontend\Subscription\Notifier;

final class SubscriptionMessage
{
    private int $subscriptionId;

    public function __construct(int $subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
    }

    public function getSubscriptionId(): int
    {
        return $this->subscriptionId;
    }
}

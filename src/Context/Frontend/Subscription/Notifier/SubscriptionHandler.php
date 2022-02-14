<?php

declare(strict_types=1);

namespace App\Context\Frontend\Subscription\Notifier;

use App\Context\Frontend\Subscription\Notifier\Helper\SubscriptionEmailSender;
use App\Repository\Subscription\SubscriptionQuery;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SubscriptionHandler implements MessageHandlerInterface
{
    private SubscriptionQuery       $subscriptionQuery;
    private SubscriptionEmailSender $subscriptionEmailSender;

    public function __construct(SubscriptionQuery $subscriptionQuery, SubscriptionEmailSender $subscriptionEmailSender)
    {
        $this->subscriptionQuery = $subscriptionQuery;
        $this->subscriptionEmailSender = $subscriptionEmailSender;
    }

    public function __invoke(SubscriptionMessage $subscriptionMessage)
    {
        $subscriptionId = $subscriptionMessage->getSubscriptionId();
        $subscriptionEntity = $this->subscriptionQuery->findSubscriptionById($subscriptionId);
        $this->subscriptionEmailSender->send($subscriptionEntity);
    }
}

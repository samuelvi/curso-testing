<?php
declare(strict_types=1);

namespace App\Context\Frontend\Subscription\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class SubscriptionHandler
{
    public function handle(FormInterface $form, Request $request)
    {
        $validSubscription = $form->getData();
        $this->subscriptionManager->createSubscription($validSubscription);
        return true;
    }
}

<?php
declare(strict_types=1);

namespace App\Validator\Constraints\Subscription;

use App\Entity\SubscriptionEntity;
use App\Repository\Subscription\SubscriptionQuery;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/** @Annotation */
class EmailUniqueValidator extends ConstraintValidator
{
    private SubscriptionQuery $subscriptionQuery;

    public function __construct(SubscriptionQuery $subscriptionQuery)
    {
        $this->subscriptionQuery = $subscriptionQuery;
    }

    public function validate($value, Constraint $constraint)
    {
        $email = $this->context->getRoot()->getViewData()->getEmail();

        /** @var SubscriptionEntity $subscriptionEntity */
        $subscriptionEntity = $this->subscriptionQuery->findSubscriptionByEmail($email);

        if ($subscriptionEntity !== null) {
            $this->context->buildViolation(sprintf('The e-mail "%s" is already subscribed', $email))
                          ->atPath('property')
                          ->addViolation()
            ;
        }
    }
}

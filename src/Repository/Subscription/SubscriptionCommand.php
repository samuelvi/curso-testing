<?php

namespace App\Repository\Subscription;

use App\Entity\SubscriptionEntity;
use App\Model\ContactDetailModel;
use Doctrine\ORM\EntityManagerInterface;

class SubscriptionCommand
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createSubscriptionFromContactDetails(ContactDetailModel $contactDetailModel)
    {
        $subscriptionEntity = SubscriptionEntity::createFromContactDetail($contactDetailModel);
        $this->em->persist($subscriptionEntity);
        $this->em->flush();
    }
}

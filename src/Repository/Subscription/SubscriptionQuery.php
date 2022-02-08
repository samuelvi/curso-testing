<?php

namespace App\Repository\Subscription;

use App\Entity\SubscriptionEntity;
use Doctrine\ORM\EntityManagerInterface;

class SubscriptionQuery
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getNumberOfSubscriptions()
    {
        return $this->em->getRepository(SubscriptionEntity::class)->getNumberOfSubscriptions();
    }

    public function getSubscriptionById($id)
    {
        return $this->em->getRepository(SubscriptionEntity::class)->find($id);
    }

    public function existsSubscriptionByEmail($email)
    {
        return (null !== $this->findSubscriptionByEmail($email));
    }

    public function findSubscriptionByEmail($email): ?SubscriptionEntity
    {
        return $this->em->getRepository(SubscriptionEntity::class)->findOneByEmail($email);
    }

    public function getAllSubscriptionsByEmailAndFullName($email, $fullName)
    {
        $params = ['email' => $email, 'fullname' => $fullName];
        return $this->em->getRepository(SubscriptionEntity::class)->findBy($params);
    }
}

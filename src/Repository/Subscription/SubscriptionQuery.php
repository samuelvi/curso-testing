<?php

namespace App\Repository\Subscription;

use App\Entity\SubscriptionEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SubscriptionQuery extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubscriptionEntity::class);
    }

    public function getNumberOfSubscriptions()
    {
        return $this->getEntityManager()->getRepository(SubscriptionEntity::class)->getNumberOfSubscriptions();
    }

    public function getSubscriptionById($id)
    {
        return $this->getEntityManager()->getRepository(SubscriptionEntity::class)->find($id);
    }

    public function existsSubscriptionByEmail($email)
    {
        return (null !== $this->findSubscriptionByEmail($email));
    }

    public function findSubscriptionByEmail($email): ?SubscriptionEntity
    {
        return $this->getEntityManager()->getRepository(SubscriptionEntity::class)->findOneByEmail($email);
    }

    public function getAllSubscriptionsByEmailAndFullName($email, $fullName)
    {
        $params = ['email' => $email, 'fullname' => $fullName];
        return $this->getEntityManager()->getRepository(SubscriptionEntity::class)->findBy($params);
    }
}

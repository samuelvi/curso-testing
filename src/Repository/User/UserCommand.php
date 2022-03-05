<?php

declare(strict_types=1);

namespace App\Repository\User;

use App\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;

final class UserCommand
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function saveUser(UserEntity $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}

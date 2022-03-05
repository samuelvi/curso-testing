<?php

namespace App\Context\Security\Verification;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class VerificationHandler
{
    private $verifyEmailHelper;

    private $entityManager;

    public function __construct(VerifyEmailHelperInterface $helper, EntityManagerInterface $manager)
    {
        $this->verifyEmailHelper = $helper;
        $this->entityManager = $manager;
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function handle(Request $request, UserInterface $user): void
    {
        $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());

        $user->setIsVerified(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}

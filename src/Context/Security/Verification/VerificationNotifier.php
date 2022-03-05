<?php

declare(strict_types=1);

namespace App\Context\Security\Verification;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Model\VerifyEmailSignatureComponents;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

final class VerificationNotifier
{
    private MailerInterface $mailer;
    private VerifyEmailHelperInterface $verifyEmailHelper;

    public function __construct(MailerInterface $mailer, VerifyEmailHelperInterface $verifyEmailHelper)
    {
        $this->mailer = $mailer;
        $this->verifyEmailHelper = $verifyEmailHelper;
    }

    public function notify(UserInterface $userEntity): void
    {
        $signatureComponents = $this->generateSignature('app_verify_email', $userEntity);

        $templatedEmail = $this->buildTemplatedEmail($userEntity);
        $templatedEmail->context($this->buildContext($signatureComponents));

        $this->mailer->send($templatedEmail);
    }

    private function buildTemplatedEmail(UserInterface $user): TemplatedEmail
    {
        return (new TemplatedEmail())
            ->from(new Address('symfonyfue@admin.com', 'Symfony FUE'))
            ->to($user->getEmail())
            ->subject('Please Confirm your Email')
            ->htmlTemplate('notification/security/registration/validation_required_after_user_registration.twig')
        ;
    }

    private function generateSignature(string $verifyEmailRouteName, UserInterface $userEntity): VerifyEmailSignatureComponents
    {
        return $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            (string)$userEntity->getId(),
            $userEntity->getEmail(),
            ['id' => $userEntity->getId()]
        );
    }

    private function buildContext(VerifyEmailSignatureComponents $signatureComponents): array
    {
        $context = [];
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        return $context;
    }
}

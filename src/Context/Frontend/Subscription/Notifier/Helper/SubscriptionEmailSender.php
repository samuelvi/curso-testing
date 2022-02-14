<?php

declare(strict_types=1);

namespace App\Context\Frontend\Subscription\Notifier\Helper;

use App\Entity\SubscriptionEntity;
use League\HTMLToMarkdown\HtmlConverter;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class SubscriptionEmailSender
{
    private MailerInterface $mailer;
    private string          $webmasterEmail;

    public function __construct(MailerInterface $mailer, string $webmasterEmail)
    {
        $this->mailer = $mailer;
        $this->webmasterEmail = $webmasterEmail;
    }

    public function send(SubscriptionEntity $subscriptionEntity): void
    {
        $bodyHtml = 'This is a Subscription Confirmation e-mail!';

        $email = new Email();
        $email->from($this->webmasterEmail)
              ->to($subscriptionEntity->getEmail())
              ->subject('Confirm Subscription')
              ->text((new HtmlConverter())->convert($bodyHtml))
              ->html($bodyHtml)
        ;

        $this->mailer->send($email);
    }
}

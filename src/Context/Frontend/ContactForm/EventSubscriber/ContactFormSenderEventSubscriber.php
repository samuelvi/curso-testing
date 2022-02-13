<?php

namespace App\Context\Frontend\ContactForm\EventSubscriber;

use App\Model\ContactDetailModel;
use App\Context\Frontend\ContactForm\Event\ContactFormEvent;
use League\HTMLToMarkdown\HtmlConverter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class ContactFormSenderEventSubscriber implements EventSubscriberInterface
{
    private MailerInterface $mailer;
    private string          $webmasterEmail;

    public function __construct(MailerInterface $mailer, string $webmasterEmail)
    {
        $this->mailer = $mailer;
        $this->webmasterEmail = $webmasterEmail;
    }

    public static function getSubscribedEvents()
    {
        return [ContactFormEvent::NEW_CONTACTFORM_REQUESTED => 'onNewContactForm'];
    }

    public function onNewContactForm(ContactFormEvent $event)
    {
        $this->sendConfirmationMessages($event->getContactDetail());
    }

    private function sendConfirmationMessages(ContactDetailModel $contactDetailModel): void
    {
        $bodyHtml = self::buildBody($contactDetailModel);
        $this->sendEmailToRequester($contactDetailModel, $bodyHtml);
        $this->sendEmailToWebmaster($contactDetailModel, $bodyHtml);
    }

    private static function buildBody(ContactDetailModel $contactDetail): string
    {
        $body = 'This is copy of your contact form:';
        $body .= sprintf('Name: %s%s', $contactDetail->getFullname(), PHP_EOL);
        $body .= sprintf('Subject: %s%s', $contactDetail->getSubject(), PHP_EOL);
        $body .= sprintf('Message: %s%s', $contactDetail->getMessage(), PHP_EOL);
        return $body;
    }

    protected function sendEmailToRequester(ContactDetailModel $contactDetail, string $bodyHtml): void
    {
        $email = new Email();
        $email->from($this->webmasterEmail)
              ->to($contactDetail->getEmail())
              ->subject(sprintf('Thank you %s for contacting Us!', $contactDetail->getFullname()))
              ->text((new HtmlConverter())->convert($bodyHtml))
              ->html($bodyHtml)
        ;

        $this->mailer->send($email);
    }

    protected function sendEmailToWebmaster(ContactDetailModel $contactDetail, string $bodyHtml): void
    {
        $email = new Email();
        $email->from($this->webmasterEmail)
              ->to($this->webmasterEmail)
              ->subject(sprintf('A user contacted Us! (%s)', $contactDetail->getFullname()))
              ->text((new HtmlConverter())->convert($bodyHtml))
              ->html($bodyHtml)
        ;

        $this->mailer->send($email);
    }
}

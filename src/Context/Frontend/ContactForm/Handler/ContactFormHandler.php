<?php

namespace App\Context\Frontend\ContactForm\Handler;

use App\Context\Frontend\ContactForm\Event\ContactFormEvent;
use App\Model\ContactDetailModel;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class ContactFormHandler
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(ContactDetailModel $contactDetailModel): void
    {
        $this->eventDispatcher->dispatch(
            new ContactFormEvent($contactDetailModel),
            ContactFormEvent::NEW_CONTACTFORM_REQUESTED
        );
    }
}

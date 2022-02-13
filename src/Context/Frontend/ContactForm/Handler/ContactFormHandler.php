<?php

namespace App\Context\Frontend\ContactForm\Handler;

use App\Context\Frontend\ContactForm\Event\ContactFormEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;

final class ContactFormHandler
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(FormInterface $form): void
    {
        $this->eventDispatcher->dispatch(
            ContactFormEvent::NEW_CONTACTFORM_REQUESTED,
            new ContactFormEvent($form->getData())
        );
    }
}

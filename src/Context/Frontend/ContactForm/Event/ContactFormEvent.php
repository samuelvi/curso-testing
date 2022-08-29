<?php declare(strict_types=1);

namespace App\Context\Frontend\ContactForm\Event;

use App\Model\ContactDetailModel;
use Symfony\Contracts\EventDispatcher\Event;

final class ContactFormEvent extends Event
{
    public const NEW_CONTACTFORM_REQUESTED = 'new_contactform_requested';

    private ContactDetailModel $contactDetail;

    public function __construct(ContactDetailModel $contactDetail)
    {
        $this->contactDetail = $contactDetail;
    }

    public function getContactDetail()
    {
        return $this->contactDetail;
    }
}

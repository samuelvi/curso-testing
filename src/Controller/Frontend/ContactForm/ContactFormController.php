<?php

declare(strict_types=1);

namespace App\Controller\Frontend\ContactForm;

use App\Model\ContactDetailModel;
use App\Util\LastPage;
use App\Context\Frontend\ContactForm\Form\ContactFormType;
use App\Context\Frontend\ContactForm\Handler\ContactFormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactFormController extends AbstractController
{
    private ContactFormHandler $contactFormHandler;

    public function __construct(ContactFormHandler $contactFormHandler)
    {
        $this->contactFormHandler = $contactFormHandler;
    }

    /** @Route("/contact", name="contact_form") */
    public function __invoke(Request $request): Response
    {
        $contactDetailModel = ContactDetailModel::createFromUser($this->getUser());
        $form = $this->createForm(ContactFormType::class, $contactDetailModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactFormHandler->handle($form);
            $parameters = $this->buildContactOkParameters();
            return $this->redirectToRoute('last_page_ok', ['parameters' => LastPage::encodeParameters($parameters)]);
        }

        return $this->render('frontend/contact_form/index.html.twig', ['form' => $form->createView()]);
    }

    protected function buildContactOkParameters(): array
    {
        return [
            'response' => 'OK',
            'flashbag' => [
                'success' => 'Your messages was managed successfully',
            ],
            'title' => 'You are here: Contact Form Submission',
            'messages' => ['Your messages has been properly managed', 'Please check your inbox', 'If your didn\'t receive any e-mail, please check your SPAM folder.'],
            'footer' => 'Thank you for using our services!',
        ];
    }
}

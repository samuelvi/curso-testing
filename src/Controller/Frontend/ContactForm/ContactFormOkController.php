<?php

declare(strict_types=1);

namespace App\Controller\Frontend\ContactForm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactFormOkController extends AbstractController
{
    /** @Route("/contact-ok", name="contact_form_ok") */
    public function __invoke(Request $request): Response
    {
        return $this->render('frontend/contact_form/contact_form_ok.html.twig');
    }
}

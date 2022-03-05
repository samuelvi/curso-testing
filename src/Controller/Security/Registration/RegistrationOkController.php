<?php

namespace App\Controller\Security\Registration;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationOkController extends AbstractController
{
    /** @Route("/registration-ok", name="app_register_ok") */
    public function __invoke(): Response
    {
        return $this->render('security/registration/registration_ok.html.twig');
    }
}

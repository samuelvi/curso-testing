<?php

namespace App\Controller\Legal;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CookiesController extends AbstractController
{
    /**
     * @Route("/cookies", name="legal_cookies")
     */
    public function __invoke()
    {
        return $this->render('common/legal/cookies.html.twig');
    }
}

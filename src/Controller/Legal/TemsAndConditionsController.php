<?php

namespace App\Controller\Legal;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TemsAndConditionsController extends AbstractController
{
    /**
     * @Route("/terms-and-conditions", name="legal_terms_and_conditions")
     */
    public function __invoke()
    {
        return $this->render('common/legal/terms_and_conditions.html.twig');
    }
}

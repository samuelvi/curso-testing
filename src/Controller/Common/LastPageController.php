<?php

namespace App\Controller\Common;

use App\Util\LastPage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LastPageController extends AbstractController
{
    /**
     * @Route("/last-page-ok/{parameters}", name="last_page_ok", requirements={"parameters" = ".*"}, defaults={"parameters" = ""})
     * @return Response
     */
    public function __invoke($parameters)
    {
        $parameters = LastPage::decodeParameters($parameters);
        return $this->render('common/common/last_page_ok/last_page_ok.html.twig', $parameters);
    }
}

<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function __invoke()
    {
        // TODO: Implement __invoke() method.
        die("YA");
    }
}

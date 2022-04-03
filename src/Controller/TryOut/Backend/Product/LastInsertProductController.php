<?php

declare(strict_types=1);

namespace App\Controller\TryOut\Backend\Product;

use App\Repository\Product\ProductQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class LastInsertProductController extends AbstractController
{
    private ProductQuery $productQuery;

    public function __construct(ProductQuery $productQuery)
    {
        $this->productQuery = $productQuery;
    }

    /**
     * @Route("/try-out/backend/last-insert-product", name="try_out_last_inset_product")
     */
    public function __invoke()
    {
        $productEntity = $this->productQuery->findLastInsertedProduct();
        return $this->render('try_out/backend/product/last_insert_product.html.twig', ['product' => $productEntity]);
    }
}

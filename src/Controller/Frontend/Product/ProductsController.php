<?php

declare(strict_types=1);

namespace App\Controller\Frontend\Product;

use App\Context\Frontend\Product\Builder\RequestModelBuilder;
use App\Context\Frontend\Product\Repository\CategoryFinder;
use App\Context\Frontend\Product\Repository\ProductFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    private ProductFinder  $productFinder;
    private CategoryFinder $categoryFinder;

    public function __construct(ProductFinder $productFinder, CategoryFinder $categoryFinder)
    {
        $this->productFinder = $productFinder;
        $this->categoryFinder = $categoryFinder;
    }

    /**
     * @Route("/products/{page}", name="products", defaults={"page" = 1})
     */
    public function __invoke(Request $request): Response
    {
        $requestModel = RequestModelBuilder::buildFromHttpRequest($request);

        $products = $this->productFinder->findProducts($requestModel);

        return $this->render('frontend/product/products.html.twig', [
            'products' =>  $products,
            'categories' => $this->categoryFinder->findAllCategories(),
        ]);

    }
}

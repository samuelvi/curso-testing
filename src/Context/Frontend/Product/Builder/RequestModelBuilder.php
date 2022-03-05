<?php

declare(strict_types=1);

namespace App\Context\Frontend\Product\Builder;

use App\Context\Frontend\Product\Model\RequestModel;
use Symfony\Component\HttpFoundation\Request;

final class RequestModelBuilder
{
    public static function buildFromHttpRequest(Request $request): RequestModel
    {
        $requestModel = new RequestModel();
        $requestModel->setCategoryId((int)$request->get('category_id', 0));
        $requestModel->setPage((int)$request->get('page'));

        return $requestModel;
    }
}

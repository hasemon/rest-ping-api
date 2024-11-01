<?php

declare(strict_types=1);

namespace App\Http\Controllers\Services;

use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class IndexController
{
    public function __invoke(): Response
    {
        $services = Service::query()->simplePaginate(config('app.pagination.Limit'));

        return new JsonResponse(
            data: $services
        );
    }
}

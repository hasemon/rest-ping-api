<?php

declare(strict_types=1);

namespace App\Http\Controllers\Services;

use App\Http\Resources\V1\ServiceResource;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

final class IndexController
{
    public function __invoke(): Response
    {
        $services = QueryBuilder::for(
            subject: Service::class
        )->allowedIncludes(
            includes: ['checks']
        )->allowedFilters(
            filters: [
                'url',
            ]
        )->getEloquentBuilder()->simplePaginate(
            perPage: config('app.pagination.Limit')
        );

        return new JsonResponse(
            data: ServiceResource::collection(
                resource: $services
            )
        );
    }
}

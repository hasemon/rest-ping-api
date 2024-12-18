<?php

declare(strict_types=1);

namespace App\Http\Controllers\Services;

use App\Enums\CacheKey;
use App\Http\Resources\V1\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

final class IndexController
{
    public function __invoke(Request $request): Response
    {
        // Cache all the services for the current user
        Cache::forever(
            key: CacheKey::User_services->value.'-'.auth()->id(),
            value: $cachedServices = Service::query()->where(
                column: 'user_id',
                operator: '=',
                value: auth()->id()
            )->pluck('id')->toArray()
        );

        $services = QueryBuilder::for(
            subject: Service::query()->whereIn(
                column: 'id',
                values: $cachedServices
            )
        )->allowedIncludes(
            includes: ['checks']
        )->allowedFilters(
            filters: [
                'url',
            ]
        )->getEloquentBuilder()
            ->simplePaginate(
                perPage: config('app.pagination.Limit')
            );

        return ServiceResource::collection(
            resource: $services
        )->toResponse(
            request: $request
        );
    }
}

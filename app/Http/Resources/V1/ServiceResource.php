<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use TiMacDonald\JsonApi\JsonApiResource;

/** @property Service $resource */
final class ServiceResource extends JsonApiResource
{
    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'url' => $this->resource->url,
            'created' => new DateResource(
                resource: $this->resource->created_at
            )
        ];
    }

    public function toRelationships(Request $request): array
    {
        return [
            'checks' => fn() => CheckResource::collection(
                resource: $this->whenLoaded(
                    relationship: 'checks'
                )
            )
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Services;

use App\Http\Requests\V1\Services\WriteRequest;
use App\Http\Resources\V1\ServiceResource;
use App\Jobs\Services\UpdateService;
use App\Models\Service;
use Illuminate\Bus\Dispatcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class UpdateController
{
    public function __construct(
        private Dispatcher $bus
    )
    {

    }

    public function __invoke(WriteRequest $request, Service $service): Response {
        $this->bus->dispatch(
            command: new UpdateService(
                payload: $request->payload(),
            )
        );
    }
}

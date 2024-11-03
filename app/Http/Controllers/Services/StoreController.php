<?php

declare(strict_types=1);

namespace App\Http\Controllers\Services;

use App\Http\Requests\V1\Services\WriteRequest;
use App\Http\Responses\V1\MessageResponse;
use App\Jobs\Services\CreateNewService;
use Illuminate\Bus\Dispatcher;
use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\Response;

final readonly class StoreController
{
    public function __construct(
        private Dispatcher $bus,
    ) {}

    public function __invoke(WriteRequest $request): Response|Responsable
    {
        $this->bus->dispatch(
            command: new CreateNewService(
                payload: $request->payload()
            )
        );

        return new MessageResponse(
            message: 'Service will be created in the background',
            status: Response::HTTP_ACCEPTED
        );

    }
}

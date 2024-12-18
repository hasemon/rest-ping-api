<?php

declare(strict_types=1);

namespace App\Http\Controllers\Services;

use App\Http\Responses\V1\MessageResponse;
use App\Jobs\Services\DeleteService;
use App\Models\Service;
use Illuminate\Bus\Dispatcher;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

final readonly class DeleteController
{
    public function __construct(
        private Dispatcher $bus
    ) {}

    public function __invoke(Request $request, Service $service): MessageResponse
    {
        if (! Gate::allows('delete', Service::class)) {
            throw new UnauthorizedException(
                message: __('services.v1.delete.failure'),
                code: Response::HTTP_FORBIDDEN
            );
        }

        $this->bus->dispatch(
            command: new DeleteService(
                service: $service
            )
        );

        return new MessageResponse(
            message: __('services.v1.create.success'),
            status: Response::HTTP_ACCEPTED
        );
    }
}

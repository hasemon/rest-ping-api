<?php

declare(strict_types=1);

namespace App\Factories;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use JustSteveKing\Tools\Http\Enums\Status;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Treblle\ApiResponses\Data\ApiError;
use Treblle\ApiResponses\Responses\ErrorResponse;

final class ErrorFactory
{
    public static function Create(\Throwable $exception, Request $request): ErrorResponse
    {
        return match ($exception::class){
            NotFoundHttpException::class, ModelNotFoundException::class => new ErrorResponse(
              data: new ApiError(
                 title: 'Resource not found',
                 detail: 'Requested resource does not exits',
                 instance: $request->fullUrl(),
                 code: 'HTTP-404',
                 link: 'https://docs.a2z-web.com/errors/404',
                )
            ),
            MethodNotAllowedHttpException::class,
            MethodNotAllowedException::class => new ErrorResponse(
                data: new ApiError(
                    title: 'Method not allowed',
                    detail: "Request method {$request->getMethod()} on an endpoint that only allows {$exception->getAllowedMethods()}",
                    instance: $request->fullUrl(),
                    code: 'HTTP-405',
                    link: 'https://docs.a2z-web.com/errors/405'
                )
            ),
            default => new ErrorResponse(
                data: new ApiError(
                    title: 'Something went wrong',
                    detail: 'Internal server error',
                    instance: $request->fullUrl(),
                    code: 'SER-500',
                    link: 'https://docs.a2z-web.com/errors/500'
                ),
                status: Status::INTERNAL_SERVER_ERROR
            )
        };
    }
}

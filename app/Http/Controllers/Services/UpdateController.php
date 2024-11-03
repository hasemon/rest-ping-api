<?php

declare(strict_types=1);

namespace App\Http\Controllers\Services;

use App\Http\Requests\V1\Services\WriteRequest;
use App\Models\Service;

final class UpdateController
{
    public function __invoke(WriteRequest $request, Service $service) {}
}

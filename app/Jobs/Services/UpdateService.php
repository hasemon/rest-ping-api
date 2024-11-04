<?php

namespace App\Jobs\Services;

use App\Http\Payloads\V1\CreateService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Queue\Queueable;

class UpdateService implements ShouldQueue
{
    use Queueable;
    public function __construct(
        public readonly CreateService $payload
    )
    {

    }

    public function handle(DatabaseManager $database): void
    {

    }
}

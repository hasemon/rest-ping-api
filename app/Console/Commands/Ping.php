<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\SendPing;
use App\Models\Check;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;
use Symfony\Component\Console\Attribute\AsCommand;

use function Laravel\Prompts\info;

#[AsCommand(name: 'ping', description: 'Run through all checks and perform a ping')]
final class Ping extends Command
{
    public function handle(Dispatcher $bus): void
    {
        info(
            message: 'Starting to execute ping...'
        );

        foreach (Check::query()->cursor() as $check) {
            info(
                message: "Dispatching ping: {$check->name}"
            );
            $bus->dispatchNow(
                command: new SendPing(
                    check: $check
                )
            );
        }

    }
}

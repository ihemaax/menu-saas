<?php

namespace App\Providers;

use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(CommandStarting::class, function (CommandStarting $event): void {
            $dangerousCommands = [
                'migrate:fresh',
                'migrate:reset',
                'migrate:refresh',
                'db:wipe',
            ];

            if (! in_array($event->command, $dangerousCommands, true)) {
                return;
            }

            if (app()->environment('testing')) {
                return;
            }

            if (! filter_var(env('ALLOW_DESTRUCTIVE_DB_COMMANDS', false), FILTER_VALIDATE_BOOLEAN)) {
                throw new RuntimeException(
                    "Blocked dangerous database command: {$event->command}. "
                    .'Create a backup and set ALLOW_DESTRUCTIVE_DB_COMMANDS=true only after explicit approval.'
                );
            }
        });
    }
}

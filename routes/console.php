<?php

use Database\Seeders\TheTreeRestaurantMenuSeeder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('menu:import-thetree', function () {
    $this->call('db:seed', ['--class' => TheTreeRestaurantMenuSeeder::class, '--force' => true]);
})->purpose('Import full menu data for The Tree restaurant (restaurant_id=5).');

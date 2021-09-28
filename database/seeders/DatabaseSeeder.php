<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\rolesseeder;
use Database\Seeders\TimeFormatSeeder;
use Database\Seeders\TypographySizeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(rolesseeder::class);
        $this->call(TypographySizeSeeder::class);
        $this->call(TimeFormatSeeder::class);
    }
}

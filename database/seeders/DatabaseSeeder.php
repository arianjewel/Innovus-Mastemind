<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SettingsSeeder::class,
            SliderSeeder::class,
            ServiceSeeder::class,
            TeamSeeder::class,
            ClientSeeder::class,
            ProjectSeeder::class,
            ProductCatalogSeeder::class,
            BrochureSeeder::class,
        ]);
    }
}

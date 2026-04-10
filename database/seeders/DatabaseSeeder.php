<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ArticleSeeder::class,
            ListingSeeder::class,
            SupplierSeeder::class,
            CourseSeeder::class,
            ResourceSeeder::class,
        ]);
    }
}

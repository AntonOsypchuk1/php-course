<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AuthorSeeder::class,
            CategorySeeder::class,
            BookSeeder::class,
            SystemSettingSeeder::class,
            UserSeeder::class,
            LoanSeeder::class,
            ReservationSeeder::class,
            FineSeeder::class,
        ]);
    }
}

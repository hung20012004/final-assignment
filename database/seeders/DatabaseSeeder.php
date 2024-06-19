<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Database\Seeders\LaptopDataSeeder;
use Database\Seeders\ManufactoryDatabaseSeeder;
use Database\Seeders\CategoryDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategoryDataSeeder::class,
            ManufactoryDataSeeder::class,
            LaptopDataSeeder::class,
        ]);
    }
}
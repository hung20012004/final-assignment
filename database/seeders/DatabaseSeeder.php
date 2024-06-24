<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Database\Seeders\LaptopDataSeeder;
use Database\Seeders\OrderDataSeeder;
use Database\Seeders\OrderDetailDataSeeder;
use Database\Seeders\SalaryDataDataSeeder;
use Database\Seeders\BlogDetailDataSeeder;
use Database\Seeders\CustomerDataSeeder;
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
            OrderDataSeeder::class,
            OrderDetailDataSeeder::class,
            CustomerDataSeeder::class,
            BlogDataSeeder::class,
            SalaryTableDataSeeder::class,
            

        ]);
    }
}
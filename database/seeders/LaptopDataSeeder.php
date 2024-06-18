<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Models\Laptop;

class LaptopDataSeeder extends Seeder
{
    // Insert laptops
    public function run(): void
    {
        $faker = Faker::create();
        $quantity = $faker->numberBetween(0, 100);
        DB::table('laptops')->insert([
            ['name' => 'Laptop gaming MSI Thin 15 B13UC 2044VN','category_id' => 1,'manufactory_id' => 8, 'quantity' => $quantity,'price' => '20990000', 'status' => 1], 
            ['name' => 'Laptop Dell XPS 13 Plus 71013325','category_id' => 2,'manufactory_id' => 2, 'quantity' => $quantity,'price' => '52990000','status' => 1], 
            ['name' => 'Laptop ASUS ProArt Studiobook Pro 16 OLED W7600Z3A L2048W','category_id' => 3,'manufactory_id' => 1,'quantity' => $quantity,'price' => '69490000','status' => 0], 
        ]);
    }
}

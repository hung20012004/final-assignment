<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Laptop;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    public function __construct()
    {
        $this->middleware('');
    }
    public function Create($laptops)
    {
        foreach ($laptops as $index => $laptop) {
            Laptop::create([
                'name' => $laptop,
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Laptop;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    public function Create(Request $request)
    {
        $laptops = $request->input('laptops');
        foreach ($laptops as $index => $laptop) {
            Laptop::create([
                'name' => $laptop,
            ]);
        }
        return view('thanhcong');
    }
}

<?php

namespace App\Http\Controllers;
use app\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Laptop;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    public function __construct(Request $request)
    {

    }
    public function Create($laptops)
    {
        foreach ($laptops as $index => $laptop) {
            Laptop::create([
                'name' => $laptop,
            ]);
        }
        return view('thanhcong');
    }
}

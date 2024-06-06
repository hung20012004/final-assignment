<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Laptop;
use Illuminate\Database\Eloquent\Collection;
class CheckLaptop
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $laptops = $request->input('laptops');
        $laptopadd = [];
        unset($request['laptops']);
        foreach ($laptops as $index => $laptop) {
            $check = Laptop::where('name', $laptop)->get()->first();
            if(!$check){
                array_push($laptopadd,$laptops[$index]);
            }   
        }
        if(!$laptops){
            return abort(404,'Them that bai');
        }
        $request->merge(['laptops'=>$laptopadd]);
        return $next($request);
    }
}

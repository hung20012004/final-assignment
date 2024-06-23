<?php

namespace App\Http\Controllers;

use App\Exports\LaptopsExport;
use app\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Laptop;
use App\Models\Manufactory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaptopController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index(Request $request)
    {
        $query = Laptop::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('manufactory', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        $laptops = $query->paginate(10);

        return view('user.warehouse.laptop.index-laptop', compact('laptops'));
    }
    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        $manufactories = Manufactory::all();
        $categories = Category::all();

        return view('user.warehouse.laptop.create-laptop', compact('manufactories', 'categories'));
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:laptops',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|string|max:255',
            'manufactory_id' => 'required|exists:manufactories,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $laptop = new Laptop();
        $laptop->name = $validatedData['name'];
        $laptop->price = $validatedData['price'];
        $laptop->quantity = $validatedData['quantity'];
        $laptop->status = $validatedData['status'];
        $laptop->manufactory_id = $validatedData['manufactory_id'];
        $laptop->category_id = $validatedData['category_id'];
        $laptop->save();

        return redirect()->route('laptops.index')->with('success', 'Laptop added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Laptop $laptop)
    {
        $laptop = Laptop::findOrFail($laptop->id);

        return view('user.warehouse.laptop.show-laptop', compact('laptop'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laptop $laptop)
    {
        $laptop = Laptop::findOrFail($laptop->id);
        $manufactories = Manufactory::all();
        $categories = Category::all();

        return view('user.warehouse.laptop.edit-laptop', compact('laptop','manufactories', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Laptop $laptop)
    {
        // dd($request,$laptop);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|string|max:255',
            'manufactory_id' => 'required|exists:manufactories,id',
            'category_id' => 'required|exists:categories,id',
        ]);
        $laptop->update($validatedData);

        return redirect()->route('laptops.index', $laptop)->with('success', 'Laptop updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laptop $laptop)
    {
         $laptop->delete();
         return redirect()->route('laptops.index')->with('success', 'Laptop deleted successfully!');
    }
    public function statistics()
    {
        $laptopsByCategory = Category::withCount('laptops')->get();

        $laptopsByManufactory = Manufactory::withCount('laptops')->get();

        return view('user.manager.statistic-laptop', compact('laptopsByCategory', 'laptopsByManufactory'));
    }
    public function export()
    {
        return Excel::download(new LaptopsExport, 'laptops.xlsx');
    }
}

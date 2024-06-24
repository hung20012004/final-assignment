<?php

namespace App\Http\Controllers;

use App\Exports\LaptopsExport;
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

        // Filtering based on search keyword
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('manufactory', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        // Paginate results and load view with laptops
        $laptops = $query->get();

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
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'quantity' => 'required|integer|min:0',
        'manufactory_id' => 'required|exists:manufactories,id',
        'category_id' => 'required|exists:categories,id',
        'CPU' => 'nullable|string|max:255',
        'VGA' => 'nullable|string|max:255',
        'RAM' => 'nullable|string|max:255',
        'hard_drive' => 'nullable|string|max:255',
        'display' => 'nullable|string|max:255',
        'battery' => 'nullable|string|max:255',
        'weight' => 'nullable|numeric',
        'material' => 'nullable|string|max:255',
        'OS' => 'nullable|string|max:255',
        'size' => 'nullable|string|max:255',
        'ports' => 'nullable|string|max:255',
        'keyboard' => 'nullable|string|max:255',
        'audio' => 'nullable|string|max:255',
    ]);

    // Determine the default status based on quantity
    if ($request->quantity > 0) {
        $validatedData['status'] = 'In stock';
    } else {
        $validatedData['status'] = 'Out of stock';
    }

    // Create the laptop
    Laptop::create($validatedData);

    return redirect()->route('laptops.index')->with('success', 'Laptop created successfully.');
}


    /**
     * Display the specified resource.
     */
    public function show(Laptop $laptop)
    {
        // Retrieve laptop details and load view
        $laptop = Laptop::findOrFail($laptop->id);

        return view('user.warehouse.laptop.show-laptop', compact('laptop'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laptop $laptop)
    {
        // Retrieve laptop details along with related data and load edit view
        $laptop = Laptop::findOrFail($laptop->id);
        $manufactories = Manufactory::all();
        $categories = Category::all();

        return view('user.warehouse.laptop.edit-laptop', compact('laptop', 'manufactories', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laptop $laptop)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'manufactory_id' => 'required|exists:manufactories,id',
        'category_id' => 'required|exists:categories,id',
        'CPU' => 'nullable|string|max:255',
        'VGA' => 'nullable|string|max:255',
        'RAM' => 'nullable|string|max:255',
        'hard_drive' => 'nullable|string|max:255',
        'display' => 'nullable|string|max:255',
        'battery' => 'nullable|string|max:255',
        'weight' => 'nullable|numeric|min:0',
        'material' => 'nullable|string|max:255',
        'OS' => 'nullable|string|max:255',
        'size' => 'nullable|string|max:255',
        'ports' => 'nullable|string|max:255',
        'keyboard' => 'nullable|string|max:255',
        'audio' => 'nullable|string|max:255',
    ]);

    $laptop->name = $request->name;
    $laptop->price = $request->price;
    $laptop->quantity = $request->quantity;
    $laptop->manufactory_id = $request->manufactory_id;
    $laptop->category_id = $request->category_id;
    $laptop->CPU = $request->CPU;
    $laptop->VGA = $request->VGA;
    $laptop->RAM = $request->RAM;
    $laptop->hard_drive = $request->hard_drive;
    $laptop->display = $request->display;
    $laptop->battery = $request->battery;
    $laptop->weight = $request->weight;
    $laptop->material = $request->material;
    $laptop->OS = $request->OS;
    $laptop->size = $request->size;
    $laptop->ports = $request->ports;
    $laptop->keyboard = $request->keyboard;
    $laptop->audio = $request->audio;

    if ($request->status == 'Discontinued') {
        $laptop->status = 'Discontinued';
    } else {
        if ($request->quantity > 0) {
            $laptop->status = 'In stock';
        } else {
            $laptop->status = 'Out of stock';
        }
    }

    $laptop->save();

    return redirect()->route('laptops.index')->with('success', 'Laptop updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laptop $laptop)
    {
        // Delete laptop instance
        $laptop->delete();

        return redirect()->route('laptops.index')->with('success', 'Laptop deleted successfully!');
    }

    /**
     * Export laptops data to Excel.
     */
    public function export()
    {
        return Excel::download(new LaptopsExport, 'laptops.xlsx');
    }
}

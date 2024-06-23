<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Manufactory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ManufactoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Manufactory::query();
        
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $manufactories = $query->paginate(10);

        return view('user.warehouse.manufactory.index-manufactory', compact('manufactories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.warehouse.manufactory.create-manufactory');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'started_at' => 'nullable|date',
        ]);

        $manufactory = new Manufactory();
        $manufactory->name = $validatedData['name'];
        $manufactory->description = $validatedData['description'] ?? null;
        $manufactory->started_at = $validatedData['started_at']?? null;
        $manufactory->save();

        return redirect()->route('manufactories.index')->with('success', 'Manufactory added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manufactory $manufactory)
    {
        return view('user.warehouse.manufactory.edit-manufactory', compact('manufactory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manufactory $manufactory)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'started_at' => 'nullable|date',
        ]);

        $manufactory->update($validatedData);

        return redirect()->route('manufactories.index', $manufactory)->with('success', 'Manufactory updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manufactory $manufactory)
    {
        $manufactory->delete();
        return redirect()->route('manufactories.index')->with('success', 'Manufactory deleted successfully!');
    }
}

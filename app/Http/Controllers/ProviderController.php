<?php
namespace App\Http\Controllers;

use App\Exports\ProvidersExport;
use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ProviderController extends Controller
{
    public function index(Request $request)
    {
        $query = Provider::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        $providers = $query->paginate(10);

        return view('user.warehouse.provider.index-provider', compact('providers'));
    }

    public function create()
    {
        return view('user.warehouse.provider.create-provider');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^\d{8,11}$/|unique:providers,phone',
            'email' => 'nullable|string|email|max:255|unique:providers,email',
        ], [
            'phone.unique' => 'The phone number has already been taken.',
            'email.unique' => 'The email has already been taken.',
        ]);

        $provider = new Provider();
        $provider->name = $validatedData['name'];
        $provider->address = $validatedData['address'];
        $provider->phone = $validatedData['phone'];
        $provider->email = $validatedData['email'];
        $provider->save();

        return redirect()->route('providers.index')->with('success', 'Provider added successfully!');
    }

    public function edit(Provider $provider)
    {
        return view('user.warehouse.provider.edit-provider', compact('provider'));
    }

    public function update(Request $request, Provider $provider)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'regex:/^\d{8,11}$/',
                Rule::unique('providers')->ignore($provider->id),
            ],
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('providers')->ignore($provider->id),
            ],
        ], [
            'phone.unique' => 'The phone number has already been taken.',
            'email.unique' => 'The email has already been taken.',
        ]);

        $provider->update($validatedData);

        return redirect()->route('providers.index')->with('success', 'Provider updated successfully!');
    }

    public function destroy(Provider $provider)
    {
        $provider->delete();
        return redirect()->route('providers.index')->with('success', 'Provider deleted successfully!');
    }

    public function export()
    {
        return Excel::download(new ProvidersExport, 'providers.xlsx');
    }
}

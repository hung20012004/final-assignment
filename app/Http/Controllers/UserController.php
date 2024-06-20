<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserVerificationMail;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }
        $query->where('role', '!=', 'manager');
        $users = $query->get();
        return view('user.manager.index-user', compact('users'));
    }

    public function create()
    {
        return view('user.manager.create-user');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|in:seller,warehouse,accountant,customer-service',
        ], [
            'email.unique' => 'The email has already been taken.',
        ]);
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $pass=Str::random(8);
        $user->password = Hash::make($pass);
        $user->role = $request->input('role');
        $user->save();
        try{
            Mail::to($user->email)->send(new UserVerificationMail($user,$pass));
        }
        catch(\Exception $e){

        }
        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function show(User $user)
    {
        return view('user.manager.show-user', compact('user'));
    }

    public function edit(User $user)
    {
        return view('user.manager.edit-user', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validatedData);
        return redirect()->route('users.index', $user)->with('success', 'User information updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function statistics()
    {
        $totalUsers = User::count();
        $usersByRole = User::select('role', DB::raw('count(*) as total'))
                            ->groupBy('role')
                            ->get();
        $usersCreatedLastMonth = User::where('created_at', '>=', now()->subMonth())
                                    ->count();
        $usersCreatedByMonth = User::select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
                                ->whereYear('created_at', date('Y'))
                                ->groupBy(DB::raw('MONTH(created_at)'))
                                ->get();
        return view('user.manager.statistic-user', compact('totalUsers', 'usersByRole', 'usersCreatedLastMonth', 'usersCreatedByMonth'));
    }
}

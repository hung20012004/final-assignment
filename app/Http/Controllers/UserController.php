<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use app\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('user.manager.index-user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.manager.create-user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->input('role'));
        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|string|min:8', // Yêu cầu mật khẩu có ít nhất 8 ký tự
        //     'role' => 'required|string|in:admin,user',
        // ]);
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Str::password(8);
        $user->role = $request->input('role');
        $user->save();
        return redirect()->route('users.index', $user)->with('success', 'User created successfully!');
    }
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = User::findOrFail($user->id);

        return view('user.manager.show-user', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user = User::findOrFail($user->id);

        return view('user.manager.edit-user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            // Thêm các quy tắc validation cho các trường thông tin khác nếu cần
        ]);

        // Cập nhật thông tin người dùng với dữ liệu mới
        $user->update($validatedData);

        // Chuyển hướng người dùng đến trang hiển thị thông tin chi tiết của họ
        return redirect()->route('users.index', $user)->with('success', 'User information updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
         // Xóa người dùng
         $user->delete();

         // Chuyển hướng người dùng đến trang danh sách người dùng
         return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}

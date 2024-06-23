<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\BlogsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Blog::query();
        if($searchUser = $request->input('searchUser'))
        {
            $query->whereHas('user', function($q) use ($searchUser){
                $q->where('name', 'like',"%$searchUser%");
            });
        }
        $blogs = $query->get();
        return view('user.seller.blog.index-blog', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('user.seller.blog.create-blog', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'user_name' => 'required|integer',
        'content' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'file' => 'required|file|max:2048',
    ]);

    // File Upload
    $filePath = null;
    if ($request->hasFile('file')) {
        $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
    }

    // Create Blog Instance
    $blog = new Blog();
    $blog->title = $validatedData['title'];
    $blog->user_id = $validatedData['user_name'];
    $blog->content = $validatedData['content'];
    $blog->author = $validatedData['author'];

    // Assign File Path
    if ($filePath) {
        $blog->file_path = '/storage/' . $filePath;
    }

    // Save Blog to Database
    $blog->save();

    // Redirect with Success Message
    return redirect()->route('blogs.index')->with('success', 'Blog created successfully!');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $blog = Blog::findOrFail($blog->id);
        return view('user.seller.blog.show-blog', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $blog = Blog::findOrFail($blog->id);
        $users = User::all();

        return view('user.seller.blog.edit-blog', compact('blog', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'user_name' => 'required|integer',
        'content' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'file' => 'nullable|file|max:2048', // Cho phép cập nhật tệp tin, giới hạn dung lượng tối đa là 2048 KB (2MB)
    ]);
        $blog->title = $validatedData['title'];
        $blog->user_id = $validatedData['user_name'];
        $blog->content = $validatedData['content'];
        $blog->author = $validatedData['author'];

    // Check if there's a new file uploaded
    if ($request->hasFile('file')) {
        // Delete old file if exists
        if ($blog->file_path) {
            Storage::delete(str_replace('/storage/', 'public/', $blog->file_path));
        }

        // Upload new file
        $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');

        // Update file_path in Blog model
        $blog->file_path = '/storage/' . $filePath;
    }

    // Save updated Blog to Database
     $blog->save();


         return redirect()->route('blogs.index')->with('success', 'Blog updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index')->with('update', 'Blog deleted successfully!');
    }

     public function export()
    {
        return Excel::download(new BlogsExport(), 'blogs.xlsx');
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\BlogsExport;
use Maatwebsite\Excel\Facades\Excel;
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
            'title'=> 'required|string|max:255',
            'user_name'=> 'required|string|max:255',
            'content'=> 'required|string|max:255',
            'author'=> 'required|string|max:255',
        ]);

        $blog = new Blog();
        $blog->title = $validatedData['title'];
        $blog->user_id = $validatedData['user_name'];
        $blog->content = $validatedData['content'];
        $blog->author = $validatedData['author'];
        $blog->save();
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
    public function update(Request $request, string $id)
    {
         $validatedData = $request->validate([
            'title'=> 'required|string|max:255',
            'user_name'=> 'required|string|max:255',
            'content'=> 'required|string|max:255',
            'author'=> 'required|string|max:255',
        ]);

        $blog = new Blog();
        $blog->title = $validatedData['title'];
        $blog->user_id = $validatedData['user_name'];
        $blog->content = $validatedData['content'];
        $blog->author = $validatedData['author'];
        $blog->update();

          return redirect()->route('blogs.index')->with('update', 'Blog updated successfully!');
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;


class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::orderByDESC('id')->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create'); 
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image = "";
        if ($request->has('image')) {

            $dir      = "uploads/blogs/";
            $file     = $request->file('image');
            $fileName = time().'-service.'.$file->getClientOriginalExtension();
            $file->move($dir, $fileName);
            $fileName = $dir.$fileName;
            $image = asset($fileName);
        }

        Blog::create([
            "username"=>auth()->user()->name,
            "title"=>$request->title,
            "description"=>$request->description,
            "image"=> $image
        ]);

        return redirect('admin/blogs')->with("success", "Blog Created");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::find($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blog = Blog::find($id);
        if ($request->has('image')) {

            $dir      = "uploads/blogs/";
            $file     = $request->file('image');
            $fileName = time().'-service.'.$file->getClientOriginalExtension();
            $file->move($dir, $fileName);
            $fileName = $dir.$fileName;
            $blog->image = asset($fileName);
        }
       
        $blog->title=$request->title;
        $blog->description=$request->description;
        $blog->save();
      

        return redirect('admin/blogs')->with("success", "Blog updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::find($id);
        $blog->delete();
        return 1;
    }
}

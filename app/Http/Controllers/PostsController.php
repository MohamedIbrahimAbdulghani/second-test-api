<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Posts::get();
        return view('posts.posts', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Posts::create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->back()->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Posts $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Posts $posts, $id)
    {
        $post = Posts::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $posts = Posts::findOrFail($id);
        $posts->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);
        return redirect()->back()->with('edit', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posts $posts, $id)
    {
        $posts = Posts::findOrFail($id);
        $posts->delete();
        return redirect()->back()->with('delete', 'Post deleted successfully.');
    }
}
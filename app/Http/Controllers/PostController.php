<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::latest()->get();
        //return $post;
        return view('post.post', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('dalam.post.create');
        return view('post.create', [
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        // @ddd($request);
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:posts',
            'image' => 'image|mimes:jpg,png,jpeg|file|max:1024',
            'body' => 'required',
            'category_id' => 'required'
        ]);

        $validatedTag = $request->validate([
            'tag' => 'required'
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('post-images');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);

        $post = Post::create($validatedData);
        if ($request->has('tag')) {
            $post->tags()->attach($request->tag);
        }
        //return redirect('post')->with('success', 'New post has been added!');

        if ($post) {
            return redirect()
                ->route('post.index')
                ->with([
                    'success' => 'New post has been created successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again'
                ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {

        foreach ($post->tags as $posttags) {
            $taging[] = $posttags->id;
        }
        return view('post.edit', [
            'post' => $post,
            'taging' => $taging,
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $rules = [
            'title' => 'required|max:255',
            // 'slug' => 'required|unique:posts',
            'image' => 'image|mimes:jpg,png,jpeg|file|max:1024',
            'body' => 'required',
            'category_id' => 'required'
        ];

        $validatedTag = $request->validate([
            'tag' => 'required'
        ]);

        if ($request->slug != $post->slug) {
            $rules['slug'] = 'required|unique:posts';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldimage) {
                Storage::delete($request->oldimage);
            }
            $validatedData['image'] = $request->file('image')->store('post-images');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);
        // if (isset($request->tag)) {
        //     $post->tags()->sync($request->tag);
        // } else {
        //     $post->tags()->sync(array());
        // }
        if ($request->has('tag')) {
            $post->tags()->sync($request->tag);
        }
        $post = Post::where('id', $post->id)->update($validatedData);

        if ($post) {
            return redirect()
                ->route('post.index')
                ->with([
                    'success' => 'Post has been updated successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem has occured, please try again'
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::delete($post->image);
        }
        Post::destroy($post->id);
        return redirect('post')->with('success', 'Post has been deleted !');
    }

    /**
     * Display a listing of the resource Custom.
     *
     * @return \Illuminate\Http\Response
     */

    public function blog()
    {
        $blogs = Post::latest()->filter(request(['search', 'author', 'category', 'tags']))->paginate(5)->withQueryString();
        return view('blog', compact('blogs'));
        //return $blogs;
        // return view('luar.isi.blogs', [
        //     "title" => "Blog",
        //     "tagtitle" => "Halaman Blog",
        //     "blogs" => Post::with(['user', 'category'])->latest()->filter(request(['search', 'author', 'category']))->paginate(5)->withQueryString()
        // ]);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\API\MsgController as MsgController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends MsgController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Post::latest()->get();
        // return response()->json(BlogResource::collection($data));
        return $this->sendResponse(BlogResource::collection($data), 'Blog fetched.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validatedData = Validator::make($input, [
            'title' => 'required',
            'slug' => 'required|string|min:4|unique:posts',
            'body' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg|file|max:1024',
            'category_id' => 'required',
            'tag' => 'required'
        ]);

        if ($validatedData->fails()) {
            return $this->sendError('Validation Error.', $validatedData->errors());
        }

        if ($request->file('image')) {
            $images = $request->file('image')->store('post-images');
        }else{
            $images = null;
        }

        $data = Post::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'body' => $request->body,
            'excerpt' => Str::limit(strip_tags($request->body), 200),
            'image' => $images,
            'category_id' => $request->category_id,
            'user_id' => auth()->user()->id
        ]);

        if ($request->has('tag')) {
            $data->tags()->attach($request->tag);
        }

        if ($data) {
            return $this->sendResponse(new BlogResource($data), 'Blog created.');
        } else {
            return $this->sendError('Blog not created.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Post::find($id);
        if (is_null($data)) {
            // return response()->json('Data not found', 404);
            return $this->sendError('Blog does not exist.');
        }
        // return response()->json(new BlogResource($data));
        return $this->sendResponse(new BlogResource($data), 'Blog fetched.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validatedData = Validator::make($input, [
            'title' => 'required',
            'body' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg|file|max:1024',
            'category_id' => 'required',
            'tag' => 'required'
        ]);

        if ($validatedData->fails()) {
            return $this->sendError('Validation Error.', $validatedData->errors());
        }

        $data = Post::findOrFail($id);
        // if ($request->slug != $post->slug) {
        //     $rules['slug'] = 'required|unique:posts';
        // }
        if ($request->file('image')) {
            if ($data->image) {
                Storage::delete($data->image);
            }
            $images = $request->file('image')->store('post-images');
        }else{
            $images = $data->image;
        }

        if ($request->has('tag')) {
            $data->tags()->sync($request->tag);
        }

        $dataupdate = $data->update([
            'title' => $request->title,
            'body' => $request->body,
            'excerpt' => Str::limit(strip_tags($request->body), 200),
            'image'=> $images,
            'category_id' => $request->category_id,
            'user_id' => auth()->user()->id
        ]);

        if ($dataupdate) {
            return $this->sendResponse(new BlogResource($data),'Blog updated.');
        }else{
            return $this->sendError('Blog not updated.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Post::findOrFail($id);
        $result = $blog->delete();
        if (!$result) {
            return $this->sendError('Blog does not exist.');
        }

        return $this->sendResponse([], 'Blog deleted.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Tag;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index')->with([
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        return view('posts.create')->with([
            'tags' => $tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|unique:posts|max:255',
            'content' => 'required',
            ]
        );

        $post  = new Post;
        $post->title  = $request->get('title');
        $post->content = $request->get('content');
        $post->user_id = Auth::user()->id;
        if($request->file('fileToUpload') != null){
            $path = $request->file('fileToUpload')->store('post_images');
            $post->post_images = $path;
        }
        $post->save();
        $post->tags()->sync($request->get('tags'));
        return redirect( '/post');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);
        //$comments = Comment::where('post_id',$post->id)->get();
        $tags = $post->tags;
        $comments = $post->comments;
        return view('posts.show')->with([
            'post' => $post,
            'comments' => $comments,
            'tags' => $tags
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $tags = Tag::all();
        if($post->user_id == Auth::user()->id)
            return view('posts.edit')->with([
                'post' => $post,
                'tags' => $tags
            ]);
        else return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id ,Request $request )
    {
        $post = Post::find($id);
        $post->title = $request->get('title');
        $post->content = $request->get('content');
        if($request->file('image') != null) {
            $path = $request->file('image')->store('post_images');
            $post->post_images = $path;
        }
        $post->save();
        $post->tags()->sync($request->get('tags'));
        return redirect( '/post/'.$request->get($id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post->user_id == Auth::user()->id){
            $post->delete();
            return redirect( '/post');
        }
        else return back();
    }


}

<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {      
        $validated = $request->validate([
                'content' => 'required',
            ]
        );

        $id = $request->post_id;
        $post = Post::find($id);
        $comment = new Comment($request->all());
        $comment->user_id = Auth::user()->id;
        // $comment->content = $request->content;
        //$comment->post_id = $request->post_id;
        //$comment->save();
        $post->comments()->save($comment);
        
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->comment_id;
        $comment = Comment::find($id);
        if($comment->user_id == Auth::user()->id){
            $comment->content = $request->content;
            $comment->save();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->comment_id;
        $comment = Comment::find($id);
        if($comment->user_id == Auth::user()->id){
            $comment->delete();
        }
        return back();
    }
}

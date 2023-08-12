<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reactions;
use App\Http\Requests\StoreReactionsRequest;
use App\Http\Requests\UpdateReactionsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionsController extends Controller
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
        $post = Post::find($request->get('post_id'));
        $reaction = Reactions::where('user_id',Auth::id())->where('post_id', $request->get('post_id'))->first();  
        if($reaction == null){
            $reaction = new Reactions();
            $reaction->post_id = $request->get('post_id');
            $reaction->user_id = Auth::id();
            $reaction->save();    
            return['action' => 'liked','reaction' => $reaction , 'count' => $reaction->post->reactions->count()];
        }else{
            $reaction->delete();
            return['action' => 'unliked' , 'count' => $reaction->post->reactions->count()];
        }
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Reactions $reactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reactions $reactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReactionsRequest $request, Reactions $reactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reactions $reactions)
    {
        //
    }
}

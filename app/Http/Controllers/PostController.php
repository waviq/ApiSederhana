<?php

namespace App\Http\Controllers;

use App\Post;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function add(Request $request, Post $post){
        $this->validate($request,[
            'content'       =>  'required|min:10'
        ]);

        $post = $post->create([
            'user_id'        =>  Auth::user()->id,
            'content'        =>  $request->content,
        ]);

        $respon = fractal()
            ->item($post)
            ->transformWith(new PostTransformer)
            ->toArray();

        return response()->json($respon, 201);
    }
}

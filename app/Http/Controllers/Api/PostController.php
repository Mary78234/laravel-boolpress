<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Post::paginate(3);

        $posts = DB::table('posts')
            ->select(
                'posts.id', 
                'posts.title', 
                'posts.content', 
                'posts.slug',
                'posts.cover',
                'posts.created_at as date', 
                'categories.name as category')
            ->join('categories', 'posts.category_id', 'categories.id')
            ->orderBy('posts.id','desc')
            ->paginate(3);
        
        $posts->each(function($post){
            if($post->cover){
                $post->cover = url('storage/' . $post->cover);
            } else {
                $post->cover = url('img/default-fallback-image.png');
            }
        });
        //$posts = Post::with(['category', 'tags'])->get();

        return response()->json($posts);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->with(['category', 'tags'])->first();

        if($post){
            $data = [
                'success' => true,
                'data' => $post
            ];
            return response()->json($data);
        }

        return response()->json(['success' => false]);
    }

}

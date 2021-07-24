<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
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
        $posts = Post::all();
        $categories = Category::all();
        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {   
        $data = $request->all();
        //dd($data); //controllo se caricato i dati
        $data['slug'] = Str::slug($data['title'], '-');
        $slug_exist = Post::where('slug', $data['slug']);
        $counter = 0;

        while($slug_exist){
            $title = $data['title'] . '-' . $counter;
            $slug = Str::slug($title, '-');
            $data['slug'] = $slug;
            $slug_exist = Post::where('slug', $slug)->first();
            $counter++;
        }

        if(array_key_exists('cover', $data)){
            $data['cover_original_name'] = $request->file('cover')->getClientOriginalName();
            $img_path = Storage::put('uploads', $data['cover']);
            $data['cover'] = $img_path;
        }

        $new_post = new Post();
        $new_post->fill($data);
        $new_post->save();

        //verifica se esiste la chiave
        if(array_key_exists('tags', $data)){
            $new_post->tags()->attach($data['tags']);
        }

        return redirect()->route('admin.posts.show', $new_post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        if(!$post){
            abort(404);
        }
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::all();
        $tags = Tag::all();

        if(!$post){
            abort(404);
        }
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $data = $request->all();
        //controllo se è stato modificato il titolo
        if($post->title !== $data['title']){
            $slug = Str::slug($data['title'], '-');
            $slug_exist = Post::where('slug', $slug)->first();
            $counter = 0;
            while($slug_exist){
                $title = $data['title'] . '-' . $counter;
                $slug = Str::slug($title, '-');
                $data['slug'] = $slug;
                $slug_exist = Post::where('slug', $slug)->first();
                $counter++;
            }
        }else{
            $data['slug'] = $post->slug;
        }

        if(array_key_exists('cover', $data)){
            if($post->cover){//se esiste un immagine da sostituire elimino quella vecchia
                Storage::delete($post->cover);
            }

            $data['cover_original_name'] = $request->file('cover')->getClientOriginalName();
            $img_path = Storage::put('uploads', $data['cover']);
            $data['cover'] = $img_path;
        }

        $post->update($data);

        //se esiste chaive
        if(array_key_exists('tags', $data)){
            $post->tags()->sync($data['tags']);
        }else{
            $post->tags()->detach();
        }

        return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if($post->cover){
            Storage::delete($post->cover);
        }
        $post->delete(); //cancella post
        return redirect()->route('admin.posts.index')->with('deleted', $post->title); //messaggio di conferma cancellazione

    }
}

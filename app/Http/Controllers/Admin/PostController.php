<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Post;
use Illuminate\Http\Request;
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
        //dd($posts);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
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
        $data['slug'] = Str::slug($data['title'], '-');

        //controlla se slug esiste già comparando 'slug' di altri Post con $data['slug'] creato alla righa sopra con i dati appena inseriti
        $slug_exist = Post::where('slug', $data['slug']);
        $counter = 0;

        while($slug_exist){
            //aggiungo il numero $counter a $title in modo da avere il uno slug diverso da quello esistente
            $title = $data['title'] . '-' . $counter;
            $slug = Str::slug($title, '-');
            //riassegno a $data['slug'] il nuovo $slug appena creato
            $data['slug'] = $slug;
            //controllo se nuovo $slug creato nel ciclo non sia uguale a $slug presenti in altri Post, 
            //se non restituisce niente allora salverà in $data['slug'] lo $slug creato in questo ciclo, 
            //se $slug_exist contiene qualcosa, re-iniza il ciclo while con $counter++ in modo che il prossimo $slug abbia il titolo+numero incrementato
            $slug_exist = Post::where('slug', $slug)->first();
            $counter++;
        }

        $new_post = new Post();
        $new_post->fill($data);
        $new_post->save();
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
        if(!$post){
            abort(404);
        }
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->all();

        //controllo se è stato modificato il titolo
        if($post->title !== $data['title']){
            //faccio partire la creazione di slug (con controllo se non ci sia già uno uguale esistente)
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
            //se il titolo non è stato modificato, non serve ricreare un nuovo slug, basta assegnargli il vecchio slug
            $data['slug'] = $post->slug;
        }

        $post->update($data);
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
        $post->delete(); //cancella post
        return redirect()->route('admin.posts.index')->with('deleted', $post->title); //messaggio di conferma cancellazione

    }
}

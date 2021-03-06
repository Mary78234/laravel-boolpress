@extends('layouts.app')

@section('content')
<div class="container">
  <h1>{{ $post->title }}</h1> 

  <div>
    @if ($post->cover)

    <img class="img-fluid" src="{{ asset('storage/' . $post->cover) }}" alt="{{ $post->cover_original_name }}">
    <h5>{{ $post->cover_original_name }}</h5>
    @endif
  </div>

  <h3>
    @if ($post->category)
      Categoria: {{ $post->category->name }}
    @else
    <span> - Nessuna Categoria - </span>
    @endif  
  
  </h3> 
  <div>
    @forelse ($post->tags as $tag)
      <span class="badge badge-primary">{{ $tag->name}}</span>
    @empty
      <span> - Nessun Tag - </span> 
    @endforelse
  </div>

  <p>{{ $post->content }}</p>
  
  <div>
  <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">Go to Index</a>
  <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-info">Edit</a>
  </div>

</div>
@endsection
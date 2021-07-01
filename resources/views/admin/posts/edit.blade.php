@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Modifica: <a href="{{ route('admin.posts.show', $post) }}">{{ $post->title }}</a></h1>  
  
  <form action="{{ route('admin.posts.update', $post) }}" method="post">
    @csrf
    @method('PATCH')

    <div class="mb-3">
      <label for="title" class="form-lable">Title</label>
      <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}">
    </div>

    <div class="mb-3">
      <label for="content" class="form-lable">Content</label>
      <textarea name="content" id="content" class="form-control" value="{{ $post->title }}" rows="5">{{ $post->content }}</textarea>
    </div>

    <div>
      <button type="submit" class="btn btn-primary">Invia</button>
    </div>

  </form>

</div>
@endsection
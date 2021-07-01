@extends('layouts.app')

@section('content')
<div class="container">
  <h1>{{ $post->title }}</h1>  
  <p>{{ $post->content }}</p>
  
  <div>
  <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">Go back</a>
  <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-info">Edit</a>
  </div>

</div>
@endsection
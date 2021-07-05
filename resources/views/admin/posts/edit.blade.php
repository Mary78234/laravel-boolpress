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

    {{-- select category --}}
    <div class="mb-3">
      <label for="category_id" class="form-lable">Categoria</label>
      <select class="form-control 
      @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
        <option value=""> - selezionare una categoria - </option>
        @foreach ($categories as $category)
          <option
          @if (old('category_id', $post->category_id) == $category->id) selected @endif 
          value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>
      @error('category_id')
        <p class="text-danger">{{ $message }}</p>
      @enderror
    </div>
    {{-- ⁄select category --}}

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
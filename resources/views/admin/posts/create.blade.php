@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Crea Nuovo Post</a></h1>  

  {{-- errors: se con sono errori, resituisce 1, non ci sono restituisce 0, funzione booleana --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif 
  {{-- /errors --}}

  {{-- form inizio  --}}
  <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('POST')

    <div class="mb-3">
      <label for="title" class="form-lable">Title</label>
      <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
      @error('title')
        <p class="text-danger">{{ $message }}</p>
      @enderror
    </div>

    {{-- select category --}}
    <div class="mb-3">
      <label for="category_id" class="form-lable">Categoria</label>
      <select class="form-control 
      @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
        <option value=""> - selezionare una categoria - </option>
        @foreach ($categories as $category)
          <option
          @if (old('category_id') == $category->id) selected @endif 
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
      <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="5">{{ old('content') }}</textarea>
      @error('content')
        <p class="text-danger">{{ $message }}</p>
      @enderror
    </div>

    {{-- check box Tag --}}
    <div class="mb-3">
      <h3>Tags</h3>
      @foreach ($tags as $tag)

        <span class="d-inline-bloc mr-3">
          <input type="checkbox" 
            name="tags[]" 
            id="tag{{ $loop->iteration }}"
            value="{{ $tag->id }}"
            @if (in_array($tag->id, old('tags', [])))
              checked
            @endif
            >
          <label for="tag{{ $loop->iteration }}">{{ $tag->name }}</label>
        </span>

      @endforeach
      @error('tags')
        <p class="text-danger">{{ $message }}</p>
      @enderror
    </div>
    {{-- /check box Tag --}}

    {{-- caricamento img --}}
    <div class="mb-3">
      <label for="cover" class="form-lable">Immagine</label>
      <input type="file" name="cover" id="cover" class="form-control @error('cover') is-invalid @enderror">
      @error('cover')
        <p class="text-danger">{{ $message }}</p>
      @enderror
    </div>
    {{-- /caricamento img --}}


    <div>
      <button type="submit" class="btn btn-primary">Invia</button>
      <button type="reset" class="btn btn-primary">Reset</button>
    </div>

  </form>
  {{-- /form fine  --}}


</div>
@endsection
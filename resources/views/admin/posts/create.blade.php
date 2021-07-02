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
  <form action="{{ route('admin.posts.store') }}" method="post">
    @csrf
    @method('POST')

    <div class="mb-3">
      <label for="title" class="form-lable">Title</label>
      <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
      @error('title')
        <p class="text-danger">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-3">
      <label for="content" class="form-lable">Content</label>
      <textarea name="content" id="content" class="form-control" rows="5">{{ old('content') }}</textarea>
      @error('content')
        <p class="text-danger">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <button type="submit" class="btn btn-primary">Invia</button>
      <button type="reset" class="btn btn-primary">Reset</button>
    </div>

  </form>
  {{-- /form fine  --}}


</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Crea Nuovo Post</a></h1>  
  
  <form action="{{ route('admin.posts.store') }}" method="post">
    @csrf
    @method('POST')

    <div class="mb-3">
      <label for="title" class="form-lable">Title</label>
      <input type="text" name="title" id="title" class="form-control" value="">
    </div>

    <div class="mb-3">
      <label for="content" class="form-lable">Content</label>
      <textarea name="content" id="content" class="form-control" rows="5"></textarea>
    </div>

    <div>
      <button type="submit" class="btn btn-primary">Invia</button>
      <button type="reset" class="btn btn-primary">Reset</button>
    </div>

  </form>

</div>
@endsection
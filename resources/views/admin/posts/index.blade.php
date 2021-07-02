@extends('layouts.app')

@section('content')
<div class="container">
  <h1>I miei post</h1>  

  @if (session('deleted'))

    <span class="alert alert-success"><strong>{{ session('deleted') }}</strong> Eliminato Correttamente!</span>
  
  @endif
  
  <table class="table">

    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Slug</th>
        <th colspan="3">Actions</th>
      </tr>
    </thead>

    <tbody>

      @foreach ($posts as $post)

        <tr>
          <td> {{ $post['id'] }} </td>
          <td> {{ $post['title'] }} </td>
          <td> {{ $post['slug'] }} </td>
          <td> <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-primary">Show</a></td>
          <td><a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-info">Edit</a></td>
          <td>
            <form action="{{ route('admin.posts.destroy', $post) }}" method="post">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger">Delete</button>

            </form>
          </td>
        </tr>
        
      @endforeach

    </tbody>

  </table>

</div>
@endsection

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
        <th>Category</th>
        <th>Tags</th>
        <th colspan="3">Actions</th>
      </tr>
    </thead>

    <tbody>

      @foreach ($posts as $post)

        <tr>
          <td> {{ $post['id'] }} </td>
          <td> {{ $post['title'] }} </td>
          <td> 
            @if ($post->category)
              {{ $post->category->name }}
            @else
              -
            @endif 
          </td>
          <td>
            @forelse ($post->tags as $tag)
              <span class="badge badge-primary">{{ $tag->name }} </span>
            @empty
              -
            @endforelse
          </td>
          <td><a href="{{ route('admin.posts.show', $post) }}" class="btn btn-primary">Show</a></td>
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


  {{-- lista categorie --}}
  <ul>
    @foreach ($categories as $category)
      <li>
        <h3>{{ $category->name }}</h3>
        <ul>
          
          @forelse ($category->posts as $post_category)
            <li><a href="{{ route('admin.posts.show', $post_category->id) }}">{{ $post_category->title }}</a></li>
          @empty
            <li> - nessun post - </li>
          @endforelse

        </ul>
      </li>
    @endforeach
  </ul>
  {{-- /lista categorie --}}


</div>
@endsection

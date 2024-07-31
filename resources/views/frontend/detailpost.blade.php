@extends('layouts.app')

@section('title','Post Detail')


@section('content')
<div class="container mt-5 textWhite">
    @if ($errors->any())
    <div>
      <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    
    <div class="form-group mt-5 border border-light fade-in">
        <div class="m-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5>{{$p->user->name}}
                    @if ($p->user->role_as == 1)
                        <i class="fas fa-check-circle"></i>
                    @endif
                </h5>
                @if (Auth::check() && Auth::user()->id == $p->user_id)
                <div class="dropdown">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{route('post.edit', $p->id)}}" data-bs-toggle="modal" data-bs-target="#editPostModal{{$p->id}}" >Edit</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal{{$p->id}}" >Delete</a></li>
                    </ul>
                </div>
                @endif
            </div>
            <h1>{{$p->title}}</h1>
            <small>{{$p->created_at->diffForHumans() }}</small>
            <hr>
            <div class="row mx-auto" >
                @if(!empty($p->image))
                    <div class="col-md-12 mb-3" >
                        <img src="{{ url('uploads/posts/' . $p->image) }}" alt="{{ $p->title }}" class="img-fluid" style="width: 100%;height:300px;">
                    </div>
                    <div class="col-md-12">
                        <p>{{ $p->news_content }}
                           
                        </p>
                    </div>
                @else
                <div class="col-md-12 ">
                    <p>{{ $p->news_content, 500  }}
                       
                    </p>
                </div>
                @endif
            </div>

            <hr>
            <p style="font-size: 1.5rem; ">
                <a href="{{ url('post/', $p->id) }}" style="color:#fff;">
                    <i class="fas fa-comments"></i><span style="font-size: 15px">({{ count($p->comments) }})</span>
                </a>
            </p>

            <!-- Comment -->
            <div class="row p-2">
                <h5>Comments :</h5>

                @foreach ($p->comments as $comment)

                    <div class="col-md-12 mb-3">
                        <div class="card bg-secondary  ">
                            <div class="card-header">
                                <small>{{$comment->user->name}}
                                    @if ($comment->user->role_as == 1)
                                        <i class="fas fa-check-circle"></i>
                                    @endif
                                    | {{ $comment->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="card-body">
                                <p>
                                {{ $comment->comment }}
                                </p>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>

            <form action="{{ url('comment/'.$p->id) }}" method="POST">
                @csrf
                <input type="hidden" name="" value="">
                <div class="form-group mb-2">
                    <textarea class="form-control" name="comment" rows="1" placeholder="Add a comment"></textarea>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-warning textWhite">Comment</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Update -->
    <div class="modal fade" id="editPostModal{{$p->id}}" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true" style="color: black">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editPostModalLabel">Edit Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editPostForm" action="{{ route('post.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="post_id" value="{{ $p->id }}">
                        <div class="form-group mt-3">
                            <label for="edit_title">Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title" value="{{ $p->title }}">
                        </div>
                        <div class="form-group mt-3">
                            <label for="edit_image">Image</label>
                            <input type="file" class="form-control" id="edit_image" name="image">
                            @if (!empty($p->image))
                                <img src="{{ url('uploads/posts/' . $p->image) }}" alt="{{ $p->title }}" style="width: 100%">
                            @endif
                        </div>
                        <div class="form-group mt-3">
                            <label for="edit_news_content">News Content</label>
                            <textarea class="form-control" id="edit_news_content" name="news_content" rows="5">{{ $p->news_content }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="exampleModal{{$p->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="color: black">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Postingan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            Apakah anda yakin akan menghapus postingan ini?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <form action="{{route('post.destroy', $p->id)}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            </div>
        </div>
        </div>
    </div>



    

</div>
@endsection


@section('scripts')
    <!-- JavaScript for toggling form visibility -->
    <script>
        function toggleForm() {
            var form = document.getElementById('postForm');
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
            } else {
                form.classList.add('hidden');
            }
        }
    </script>
@endsection

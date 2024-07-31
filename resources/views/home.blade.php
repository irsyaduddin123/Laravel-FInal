@extends('layouts.app')

@section('style')
    <style>
        .hidden{
            display: none;
        }
    </style>
@endsection

@section('content')
<div class="container" style="padding-top: 7rem">
    <div class="row justify-content-center">
        <div class="col-md-4 mb-3">
            <div class="card bg-dark text-white" style="border: 1px solid #fff">
                <h3 class="card-img-top text-center p-3">
                    @if (Auth::user()->image)
                        <img src="{{ url('uploads/users/' . Auth::user()->image) }}" alt="{{ Auth::user()->name }}" style="width: 100%;max-height: 200px" />
                    @else
                        <i class="fas fa-users" style="color: #fff; font-size: 5rem;"></i>
                    @endif
                </h3>
                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                <div class="card-body">
                  <h5 class="card-title">{{ Auth::user()->name }}
                    <span class="float-end ">
                        <button type="button" class="btn btn-sm btn-warning"  data-bs-toggle="modal" data-bs-target="#imageModal">
                            <i class="fas fa-camera" ></i>
                        </button>
                    </span>
                </h5>
                  <p class="card-text">{{ Auth::user()->email }}</p>
                </div>
                <ol class="list-group list-group">
                    <div class="row gap-0">
                        <div class="col-md-6">
                            <li class="list-group-item bg-dark text-white"><h6>Carts <span class="badge bg-secondary">{{ count($carts) }}</span></h></li>
                            <li class="list-group-item bg-dark text-white"><h6>Orders <span class="badge bg-secondary">{{ count($orders) }}</span></h6></li>
                        </div>
                        <div class="col-md-6">
                            <li class="list-group-item bg-dark text-white"><h6>Posts <span class="badge bg-secondary">{{count($posts)}}</span></h6></li>
                            <li class="list-group-item bg-dark text-white"><h6>Addresses <span class="badge bg-secondary">{{count($addresses)}}</span></h6></li>
                        </div>

                    </div>
                </ol>
                <div class="card-body">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#passwordModal">Change Password</button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item " role="presentation">
                  <button class="nav-link {{ !session('tabs_home') ? 'active' : '' }} text-secondary" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="false">Home</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link text-secondary" id="cart-tab" data-bs-toggle="tab" data-bs-target="#cart-tab-pane" type="button" role="tab" aria-controls="cart-tab-pane" aria-selected="false">Cart</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link text-secondary" id="order-tab" data-bs-toggle="tab" data-bs-target="#order-tab-pane" type="button" role="tab" aria-controls="order-tab-pane" aria-selected="false">Order</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link {{ (session('tabs_home') && session('tabs_home')['type'] == 'posts') ? 'active' : '' }} text-secondary" id="post-tab" data-bs-toggle="tab" data-bs-target="#post-tab-pane" type="button" role="tab" aria-controls="post-tab-pane" aria-selected="false">Posts</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link text-secondary {{ (session('tabs_home') && session('tabs_home')['type'] == 'address') ? 'active' : '' }}" id="address-tab" data-bs-toggle="tab" data-bs-target="#address-tab-pane" type="button" role="tab" aria-controls="address-tab-pane" aria-selected="false">Addresses</button>
                </li>

            </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade {{ !session('tabs_home') ? 'show active' : '' }}" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <div class="card mt-3 mainColor" style="border: 1px solid #fff;color:#fff">
                        <div class="card-header">{{ __('Dashboard') }}</div>

                        <div class="card-body" style="border: 1px solid #fff;">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{ __('You are logged in!') }}
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="cart-tab-pane" role="tabpanel" aria-labelledby="cart-tab" tabindex="0">
                    <div class="card mt-3 mainColor" style="border: 1px solid #fff;color:#fff">
                        <div class="card-header">{{ __('Cart ') }}</div>

                        <div class="card-body" style="border: 1px solid #fff;">
                            @if ($carts->count() > 0)
                            <table class="table  table-dark table-striped">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Qty</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $cart)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $cart->product->name }}</td>
                                            <td>{{$cart->product_qty}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                              </table>
                              <a href="{{ url('/cart') }}" class="btn btn-sm btn-warning">See Details</a>

                            @else
                                <a href="{{ url('/product') }}" class="btn btn-sm btn-warning">Lets Checkout !</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="order-tab-pane" role="tabpanel" aria-labelledby="order-tab" tabindex="0">
                    <div class="card mt-3 mainColor" style="border: 1px solid #fff;color:#fff;">
                        <div class="card-header">{{ __('History') }}</div>

                        <div class="card-body" style="border: 1px solid #fff;overflow-x:scroll">
                            @if ($orders->count() > 0)
                            <table class="table  table-dark table-striped">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Order No</th>
                                    <th scope="col">nameAddress</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Details</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $order->order_code }}</td>
                                            <td>{{ $order->nameaddress}}</td>
                                            <td>{{ number_format($order->total_price, 0) }}</td>
                                            <td>{{$order->status}}</td>
                                            <td>{{$order->created_at}}</td>
                                            <td> <a href="{{ url('/checkout/'.$order->id) }}" class="btn btn-sm btn-warning">See Details</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                              </table>


                            @else
                                <a href="{{ url('/product') }}" class="btn btn-sm btn-warning">Lets Order !</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade {{ (session('tabs_home') && session('tabs_home')['type'] == 'posts') ? 'show active' : '' }}" id="post-tab-pane" role="tabpanel" aria-labelledby="post-tab" tabindex="0">
                    <div class="card mt-3 mainColor" style="border: 1px solid #fff;color:#fff">
                        <div class="card-header">{{ __('History') }}</div>

                        <div class="card-body" style="border: 1px solid #fff;">
                            <div class="form-group mt-4 mb-3">
                                <button onclick="toggleForm()" class="btn btn-warning">Toggle Create Post Form</button>
                            </div>

                            <div class="card bg-secondary">
                                <form action="{{ route('post.store') }}" class="hidden" id="postForm" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-header">
                                        <h1><center>Post</center></h1>
                                    </div>
                        
                                    <div class="card-body">
                                        <div class="form-group mt-3">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control  @error('title') is-invalid @enderror" id="title" name="title">
                                            @error('title')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                        
                                        <div class="form-group mt-3">
                                            <label for="image">Image</label>
                                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                            @error('image')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="news_content">News Content</label>
                                            <textarea class="form-control @error('news_content') is-invalid @enderror" id="news_content" name="news_content" rows="5"></textarea>
                                            @error('news_content')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                        
                                        <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="submit" class="btn btn-warning textWhite">Post</button>
                                        </div>
                        
                                    </div>
                                </form>
                            </div>

                            @foreach ($posts as $p)
                                <div class="form-group mt-5 border border-light fade-in">
                                    <div class="m-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5>{{$p->user->name}}</h5>
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
                                        @if(!empty($p->image))
                                        <div style="display: flex; justify-content: center; float: left; width:35%;height:35%; margin-right: 20px">
                                            <img src="{{ url('uploads/posts/' . $p->image) }}" alt="{{ $p->title }}" class="img-fluid" style="width: 100%;">
                                        </div>
                                        @endif
                                        <p>{{$p->news_content}}</p>
                                        <hr>

                                        <!-- Comment -->
                                        <div class="row p-2">
                                            <h5>Comments :</h5>

                                            @foreach ($p->comments as $comment)

                                                <div class="col-md-12 mb-3">
                                                    <div class="card bg-secondary  ">
                                                        <div class="card-header">
                                                            <small>{{$comment->user->name}} | {{ $comment->created_at->diffForHumans() }}</small>
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

                            @endforeach
                            {{-- @if ($posts->count() > 0)
                            @else
                                <div class="form-group mt-4 mb-3">
                                    <button onclick="toggleForm()" class="btn btn-warning">Toggle Create Post Form</button>
                                </div>
                            @endif --}}
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade {{ (session('tabs_home') && session('tabs_home')['type'] == 'address') ? 'show active' : '' }}" id="address-tab-pane" role="tabpanel" aria-labelledby="address-tab" tabindex="0">
                    <div class="card mt-3 mainColor" style="border: 1px solid #fff;color:#fff;">
                        <div class="card-header">Addresses</div>

                        <div class="card-body" style="border: 1px solid #fff;overflow-x:scroll">

                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Add Address
                            </button>

                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="Title" style="color: black">Add Address</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ url('tambahAlamat') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label text-dark">Name</label>
                                                    <input type="text" class="form-control" name="name" id="name" style="color: black" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label text-dark">Phone</label>
                                                    <input type="number" class="form-control" name="phone" id="phone" style="color: black" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="address" class="form-label text-dark">Address</label>
                                                    <textarea name="address" id="address" cols="30" rows="5" class="form-control" style="color: black" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <table class="table  table-dark table-striped">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Address Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($addresses as $address)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $address->name }}</td>
                                            <td>{{ $address->phone }}</td>
                                            <td>{{ $address->address }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit-address-{{ $address->name }}">
                                                    Edit
                                                </button>
                                                <button onclick="deleteAddress('{{ $address->id }}', '{{ $address->name }}')" class="btn btn-sm btn-danger">Delete</button>
                                                {{-- <a href="{{ url('addresses/'.$address->id.'/edit') }}" class="btn btn-sm btn-warning">Edit</a> --}}
                                                {{-- <a href="{{ url('addresses/'.$address->id.'/delete') }}" class="btn btn-sm btn-danger">Delete</a> --}}
                                            </td>
                                        </tr>

                                        {{-- Form Edit --}}
                                        <div class="modal fade" id="edit-address-{{ $address->name }}" tabindex="-1" aria-labelledby="edit-address-label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="Title" style="color: black">Add Address</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ url('addresses/'.$address->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label text-dark">Name</label>
                                                                <input type="text" class="form-control" name="name" id="name" style="color: black" value="{{ $address->name }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="phone" class="form-label text-dark">Phone</label>
                                                                <input type="number" class="form-control" name="phone" id="phone" style="color: black" value="{{ $address->phone }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="address" class="form-label text-dark">Address</label>
                                                                <textarea name="address" id="address" cols="30" rows="5" class="form-control" style="color: black" required>{{ $address->address }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Form Edit --}}

                                    @endforeach
                                </tbody>
                              </table>
                        </div>
                    </div>
                </div>
              </div>
        </div>
    </div>

    <!-- Modal Upload Image-->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload Image</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.uploadImage') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if (Auth::user()->image)
                    <img src="{{ url('uploads/users/' . Auth::user()->image) }}" alt="{{ Auth::user()->name }}" style="width: 100%;max-height: 200px" />
                @endif
                <div class="modal-body">
                    <label for="image" >Upload Image</label>
                    <input type="file" name="image" class="form-control" id="image">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <!-- Modal Change Password-->

    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.changePassword') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                        <label for="current_password">Current Password</label>
                        <input class="form-control" type="password" name="current_password" id="current_password" >


                        <label for="new_password">New Password</label>
                        <input class="form-control" type="password" name="new_password" id="new_password" >


                        <label for="new_password_confirmation">Confirm New Password</label>
                        <input class="form-control" type="password" name="new_password_confirmation" id="new_password_confirmation" >

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleForm() {
            var form = document.getElementById('postForm');
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
            } else {
                form.classList.add('hidden');
            }
        }

        function deleteAddress(id, name) {
            const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: "Are You Sure?",
                text: "Are You Sure You Want to Delete Address " + name + "?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('addresses/delete') }}`,
                    type: 'POST',
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(error) {
                        location.reload();
                    }
                });
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Cancel Delete Address " + name,
                    icon: "error"
                });
            }
            });
        }
    </script>

    @if (isset(session('tabs_home')['title']))
        <script>
            Swal.fire({
                title: "{{ session('tabs_home')['title'] }}",
                text: "{{ session('tabs_home')['text'] }}",
                icon: "{{ (isset(session('tabs_home')['icon'])) ? session('tabs_home')['icon'] : 'warning' }}"
            });
        </script>
    @endif
@endsection
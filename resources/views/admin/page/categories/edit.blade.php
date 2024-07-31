@extends('layouts.admin')
@section('content')
    <h1 class="text-center" >Categories Edit</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Category
                        <a href="{{ url('admin/categories') }}" class="btn btn-danger btn-sm" style="float: right">Back</a>
                    </h3>
                </div>
                <div class="card-body">

                    <form action="{{ url('admin/categories/'.$category->id) }}" enctype="multipart/form-data"  method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="">name</label>
                            <input type="text" name="name" value="{{ $category->name }}" class="form-control">
                            @error('name')
                                <span class="text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">Image</label>
                            @if ($category->image)
                            <div class="mb-3">
                                <img src="{{ asset($category->image) }}" alt="" style="width: 70px; height:70px" >
                            </div>
                            @endif
                            <input type="file" name="image" />
                            @error('image')
                                <span class="text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@extends('layouts.admin')
@section('content')
    <h1 class="text-center" >Categories Create</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Add Categories
                        <a href="{{ url('admin/categories') }}" class="btn btn-danger btn-sm" style="float:right;">Back</a>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/categories/create') }}" enctype="multipart/form-data"  method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="">name</label>
                            <input type="text" name="name" class="form-control">
                            @error('name')
                                <span class="text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">Image</label>
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

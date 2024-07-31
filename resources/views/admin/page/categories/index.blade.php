@extends('layouts.admin')
@section('content')
    <h1 class="text-center" >Categories</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Categories
                        <a href="{{ url('admin/categories/create') }}" class="btn btn-primary btn-sm" style="float:right;">Add Categories</a>
                    </h3>
                    @if (session('message'))
                        <div class="aler alert-success p-2">{{ session('message') }}</div>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>name</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $key => $category)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <img src="{{ asset("$category->image") }}" class="rounded" style="width:70px;height:70px" alt="">
                                    </td>
                                    <td>
                                        <a href="{{ url('admin/categories/'.$category->id.'/edit') }}" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#{{'modal'.$category->id }}">Delete</a>

                                    </td>

                                    <!-- delete Confirm Modal-->
                                    <div class="modal fade" id="{{'modal'.$category->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">Are you want to delete "{{ $category->name }}" category ?</div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                    <a class="btn btn-primary"  href="{{ url('admin/categories/'.$category->id.'/delete') }}">
                                                    Delete</a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"><H1>No Data Product</H1></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <h1 class="text-center mt-2">Addresses</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Addresses
                        <a href="{{ url('addresses/create') }}" class="btn btn-primary btn-sm" style="float:right;">Add Address</a>
                    </h3>
                    @if (session('message'))
                        <div class="alert alert-success p-2">{{ session('message') }}</div>
                    @endif
                </div>
                <div class="card-body">
                    @if($addresses->isEmpty())
                        <h1>No Addresses Available</h1>
                    @else
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addresses as $key => $address)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $address->name }}</td>
                                        <td>{{ $address->phone }}</td>
                                        <td>{{ $address->address }}</td>
                                        <td>
                                            <a href="{{ url('addresses/'.$address->id.'/edit') }}" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="{{ url('addresses/'.$address->id.'/delete') }}" class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>

                                    <!-- <div class="modal fade" id="modal{{ $address->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">Are you sure you want to delete "{{ $address->name }}" address?</div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                    <form action="{{ url('addresses/'.$address->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-primary">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

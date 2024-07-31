@extends('layouts.app')

@section('content')
    <h1 class="text-center mt-2">Edit Address</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Address
                        <a href="{{ url('address') }}" class="btn btn-primary btn-sm" style="float:right;">Back</a>
                    </h3>
                    @if (session('message'))
                        <div class="alert alert-success p-2">{{ session('message') }}</div>
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{ url('addresses/'.$address->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ $address->name }}" class="form-control">
                            @error('name')
                                <span class="text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" value="{{ $address->phone }}" class="form-control">
                            @error('phone')
                                <span class="text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address">Address</label>
                            <input type="text" name="address" value="{{ $address->address }}" class="form-control">
                            @error('address')
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

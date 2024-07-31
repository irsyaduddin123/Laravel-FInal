@extends('layouts.admin')
@section('content')
    <h1 class="text-center" >Products</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Products
                        <a href="{{ url('admin/products/create') }}" class="btn btn-primary btn-sm" style="float:right;">Add Products</a>
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
                                <th>Name</th>
                                <th>Image</th>
                                <th>Stok</th>
                                <th>Min Stok</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $key => $product)
                                @php
                                    $imgDecode = json_decode($product->image);
                                    $countImg = count($imgDecode);
                                @endphp
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $product->name }} @if ($product->stok <= $product->min_stok)<span class="badge badge-danger">Minimum Stok</span>@endif</td>
                                    <td>
                                        @if ($countImg == 0)
                                            Tidak Ada Gambar
                                        @else
                                            <img src="{{ asset($imgDecode[0]->name) }}" class="rounded" style="width:70px;height:70px" alt="">
                                            @php
                                                if ($countImg > 1 ) {
                                            @endphp
                                                    {{ $countImg - 1 }} Gambar Lainnya
                                            @php
                                            }
                                            @endphp
                                        @endif
                                    </td>
                                    <td>{{ $product->stok }}</td>
                                    <td>{{ $product->min_stok }}</td>
                                    <td>Rp {{ number_format($product->price, 0) }}</td>
                                    <td>
                                        <a href="{{ url('admin/products/'.$product->id.'/edit') }}" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#{{'modal'.$product->id }}">Delete</a>

                                    </td>

                                    <!-- delete Confirm Modal-->
                                    <div class="modal fade" id="{{'modal'.$product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">Are you want to delete "{{ $product->name }}" category ?</div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                    <a class="btn btn-primary"  href="{{ url('admin/products/'.$product->id.'/delete') }}">
                                                    Delete</a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="text-center">
                                            <p> <strong>Tidak Ada Produk</strong></p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

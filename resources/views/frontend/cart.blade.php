@extends('layouts.app')

@section('title','Cart - GearGeek Hub')

@section('style')
<style>
    .table .table-row {
        box-shadow: 0 2px 8px rgba(255, 255, 255, 0.2);
        border-radius: 15px !important;
        background: #38393d
        margin-bottom: 15px;
        overflow: hidden;
    }
    .table .table-row td {
        border: none;
        padding: 15px;
        color: white;
        vertical-align: middle;
    }
</style>
@endsection

@section('content')
<div class="container-fluid pt-5">
    <h1 class="heading textWhite"><center>Shopping Cart</center></h1>
    @if (session('message'))
        <div class="aler alert-success p-2">{{ session('message') }}</div>
    @endif
    @if (session('error'))
        <div class="aler alert-danger p-2">{{ session('error') }}</div>
    @endif
    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}
    <br>
    <div class="row cart-section rzw-card rzw-row">
        @if ($carts->count() > 0)

            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table textWhite">
                        {{-- <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Sub Total</th>
                                <th>Action</th>
                            </tr>
                        </thead> --}}
                        <tbody>
                            @php
                                $totalPrice = 0;
                            @endphp
                            @foreach ($carts as $cart)
                                @php
                                    $subTotal = $cart->product->price * $cart->product_qty;
                                    $totalPrice += $subTotal;
                                @endphp
                                <tr class="table-row">
                                    <td style="border-radius: 13px 0 0 13px"><img src="{{ asset(json_decode($cart->product->image)[0]->name) }}" style="height:50px;width:50px" alt="Product" class="img-fluid"></td>
                                    <td>{{ $cart->product->name }}</td>
                                    <td>Rp {{ number_format($cart->product->price, 0) }}</td>
                                    <td>
                                        <form action="{{ url('cart/update/'.$cart->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group quantity-input">
                                                <button type="submit" class="btn btn-warning" name="action" value="decrement">-</button>
                                                <input type="text" name="product_qty" class="form-control" disabled value="{{ $cart->product_qty }}">
                                                <button type="submit" class="btn btn-warning" name="action" value="increment">+</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>Rp {{ number_format($subTotal, 0) }}</td>
                                    <td style="border-radius: 0 13px 13px 0"><a href="{{ url('cart/delete/'.$cart->id) }}" class="btn btn-danger">Remove</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <form action="{{ url('/checkout') }}" method="POST">
                    @csrf
                    <div class="card payment rzw-card rzw-row" style="margin-right: -15px">
                        <div class="card-body">
                            <h2 class="card-title">Payment Summary</h2>
                            <p>Total Items: {{ $carts->count() }}</p>

                            <p> Total: <strong>Rp {{ number_format($totalPrice, 0) }}</strong></p>
                            <div class="py-2">
                                @if (count($address) > 0)
                                    <select class="form-control" name="address_id" >
                                        <option value="">Select Address</option>
                                        @foreach ($address as $addres)
                                            <option value="{{ $addres->id }}">{{ $addres->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('address_id')
                                        <span class="text text-danger">{{ $message }}</span>
                                    @enderror
                                @else
                                    <p>No Address <a href="{{ url('addresses/create') }}">please add Your address</a></p>
                                @endif

                            </div>
                            <div class="container text-center pt-4">
                                <button type="submit" class="btn btn-warning btn-block">Checkout</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @else
            <div class="text-center">
                <h2>No Data Cart</h2>
            </div>
        @endif

    </div>
</div>
@endsection

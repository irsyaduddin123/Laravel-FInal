@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        <div class="container mb-4">
            <a href="{{ url('/home') }}" class="btn btn-warning">Kembali</a>
        </div>
        <div class="row m-0">
            <div class="col-md-7 col-12">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="row box-right">
                            <div class="col-md-10 ps-0 ">
                                <p class="ps-3 textmuted fw-bold h6 mb-0">TOTAL PAYMENT</p>
                                <p class="h1 fw-bold d-flex px-3" style="color: green">
                                    <span class="fa-solid fa-rupiah-sign textmuted pe-1 h6 align-text-top mt-1"></span>{{ number_format($order->total_price, 0) }}
                                </p>
                                @if ($order->discount_percentage)
                                    <p class="ms-3 px-2 bg-green">Diskon {{ $order->discount_percentage * 100 }}% </p>
                                @endif
                            </div>
                            <div class="col-md-2">
                                @if ($order->status == 'Paid')
                                    <p class="p-green">
                                        <span class="fas fa-circle pe-2"></span>
                                        {{ $order->status }}
                                    </p>
                                @elseif ($order->status == 'Unpaid')
                                    <p class="p-blue">
                                        <span class="fas fa-circle pe-2" style="color: blue;"></span>
                                        {{ $order->status }}
                                    </p>
                                @else
                                    <p style="color: red;">
                                        <span class="fas fa-circle pe-2" style="color: red;"></span>
                                        {{ $order->status }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12 px-0 mb-4">
                        <div class="box-right">
                            <div class="d-flex mb-3">
                                <p class="fw-bold">Product Detail</p>
                            </div>
                            <div class="row m-0 border mb-4">
                                <div class="col-6 h8 pe-0 ps-2">
                                    <p class="textmuted py-2">Items</p>
                                    @foreach ($orderItems as $value)
                                        <span class="d-block py-2 border-bottom">{{ $value->product->name }}</span>
                                    @endforeach
                                </div>
                                <div class="col-2 h8 text-center p-0">
                                    <p class="textmuted p-2">Qty</p>
                                    @foreach ($order->order_detail as $value)
                                        <span class="d-block p-2 border-bottom">{{ $value->qty }}</span>
                                    @endforeach
                                </div>
                                <div class="col-2 p-0 text-center h8 border-end">
                                    <p class="textmuted p-2">Price</p>
                                    @foreach ($orderItems as $value)
                                        <span class="d-block border-bottom py-2">
                                            {{ number_format($value->product->price, 0) }}
                                        </span>
                                    @endforeach
                                </div>
                                <div class="col-2 h8 p-0 text-center">
                                    <p class="textmuted p-2">Total</p>
                                    @foreach ($orderItems as $value)
                                        <span class="d-block py-2 border-bottom">
                                            {{ number_format(($value->product->price * $value->qty), 0) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            @if ($order->discount_percentage)
                                <div class="d-flex h7">
                                    <p>Discount</p>
                                    <p class="ms-auto fw-bold" style="color: red;">-{{ number_format($order->discount_amount, 0) }} ({{ $order->discount_percentage * 100 }}%)</p>
                                </div>
                            @endif
                            <div class="d-flex h7">
                                <p>Total Amount</p>
                                <p class="ms-auto fw-bold" style="color: green;">Rp {{ number_format($order->total_price, 0) }}</p>
                            </div>
                        </div>
                    </div>
                    @if (isset($order->data))
                        @php
                            $dataPay = json_decode($order->data);
                        @endphp
                        @if (count($dataPay) >= 1)
                        <div class="col-12 px-0">
                            <div class="box-right">
                                <div class="d-flex mb-3">
                                    <p class="fw-bold">Transaksi Detail</p>
                                </div>
                                @foreach ($dataPay as $data)
                                    <div class="d-flex h7">
                                        <p>{{ $data->label }}</p>
                                        <p class="ms-auto fw-bold">{{ $data->value }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-md-5 col-12 ps-md-5 p-0">
                <div class="box-left mb-3">
                    <div class="col-12 px-0">
                        <div class="box-right">
                            <div class="d-flex">
                                <p class="fw-bold">Address</p>
                            </div>
                            <div class="d-flex mb-2">
                                <p class="h7">{{ $order->order_code }}</p>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <p class="textmuted h8">Nama Penerima</p>
                                    <input class="form-control" type="text" value="{{ $order->nameaddress }}" readonly>
                                </div>
                                <div class="col-12 mb-2">
                                    <p class="textmuted h8">Alamat Lengkap</p>
                                    <textarea name="address" id="address" cols="30" rows="5" class="form-control" readonly>{{ $order->address }}</textarea>
                                </div>
                                <div class="col-12 mb-2">
                                    <p class="textmuted h8">Phone Number</p>
                                    <input class="form-control" type="text" value="{{ $order->phone }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($order->status !== 'Paid' && $order->status !== 'Expire')
                    <div class="box-left mb-3">
                        <div class="col-12 px-0">
                            <div class="box-right">
                                <div class="">
                                    @if (isset(session('message')['type']))
                                        <div class="alert alert-{{ session('message')['type'] }} p-2">{{ session('message')['pesan'] }}</div>
                                    @endif
                                </div>
                                @if (!isset($order->snaptoken))
                                    <div class="d-flex mb-2">
                                        <p class="fw-bold">Redeem Code</p>
                                    </div>
                                    
                                        <form action="{{ url('paymentreedem/'.$order->id) }}" method="POST">
                                            <div class="row">
                                                <div class="col-{{ (!isset($order->snaptoken)) ? '9' : '12' }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <p class="textmuted h8"></p>
                                                    <input type="text" name="reedem_code" class="form-control" placeholder="Masukan Reedem Code" value="{{ ($order->reedem_code) ? $order->reedem_code : '' }}" {{ ($order->reedem_code) ? 'readonly' : '' }}>
                                                </div>
                                            
                                                <div class="col-3">
                                                    @if ($order->reedem_code)
                                                        <a href="{{ url('paymentreedem/'.$order->id) }}" class="btn btn-danger">Remove</a>                            
                                                    @else
                                                        <button type="submit" class="btn btn-warning">Gunakan</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                        </div>
                    
                        <div class="container pt-4">
                            <div class="form d-flex justify-content-center">
                                <form action="{{ url('payment/'.$order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning d-block h8" style="width: 30vh">Payment Now</button>
                                </form>
                                {{-- <div class="btn btn-primary d-block h8" id="pay-button">PAY
                                   <b>{{ number_format($order->total_price, 0) }}</b>
                                    <span  class="ms-3 fas fa-arrow-right"></span>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

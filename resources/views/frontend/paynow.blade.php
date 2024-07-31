@extends('layouts.app')

@section('style')
<script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="{{ config('midtrans.client_key') }}"></script>
@endsection

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
                <div class="col-12 px-0">
                    <div class="box-right">
                        <div class="d-flex mb-2">
                            <p class="fw-bold">Address</p>
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
        </div>
        <div class="col-md-5 col-12 ps-md-5 p-0 ">
            <div class="box-left">
                <p class="fw-bold h7">Invoice (#{{ $order->order_code }})</p>
                <p class="textmuted h8 mb-2">{{ $order->nameaddress }}</p>
                <div class="h8">
                    <div class="row m-0 border mb-3">
                        <div class="col-6 h8 pe-0 ps-2">
                            <p class="textmuted py-2">Items</p>
                            @foreach ($orderDetail as $value)
                                <span class="d-block py-2 border-bottom">{{ $value->product->name }}</span>
                            @endforeach
                        </div>
                        <div class="col-2 text-center p-0">
                            <p class="textmuted p-2">Qty</p>
                            @foreach ($order->order_detail as $value)
                                <span class="d-block p-2 border-bottom">{{ $value->qty }}</span>
                            @endforeach
                        </div>
                        <div class="col-2 p-0 text-center h8 border-end">
                            <p class="textmuted p-2">Price</p>
                            @foreach ($orderDetail as $value)
                                <span class="d-block border-bottom py-2">
                                    {{ number_format($value->product->price, 0) }}
                                </span>
                            @endforeach
                        </div>
                        <div class="col-2 p-0 text-center">
                            <p class="textmuted p-2">Total</p>
                            @foreach ($orderDetail as $value)
                                <span class="d-block py-2 border-bottom">
                                    {{ number_format(($value->product->price * $value->qty), 0) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @if ($order->discount_percentage)
                        <div class="d-flex h7 mb-2">
                            <p class="">Discount</p>
                            <p class="ms-auto" style="color: red;">-{{ number_format(($order->total_price * $order->discount_percentage), 0) }} ({{ $order->discount_percentage * 100 }}%)</p>
                        </div>
                    @endif
                    <div class="d-flex h7 mb-2">
                        <p class="">Total Amount</p>
                        <p class="ms-auto" style="color: green;">Rp {{ number_format($order->total_price, 0) }}</p>
                    </div>
                </div>
                @if ($order->status !== 'Paid')
                    <div class="container pt-4">
                        <div class="form">
                            <div class="btn btn-primary d-block h8" id="pay-button">PAY
                               <b>{{ number_format($order->total_price, 0) }}</b>
                                <span  class="ms-3 fas fa-arrow-right"></span>
                            </div>
                        </div>
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
    // For example trigger on button clicked, or any time you need
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay('{{$snapToken}}', {
            onSuccess: function(result){
                /* You may add your own implementation here */
                // window.location.href = '/invoice/{{$order->id}}'
                window.location.href = `/payment/checkout/${result.order_id}`;
                // alert("payment success!");
                // console.log(result);
            },
            onPending: function(result){
                /* You may add your own implementation here */
                // alert("wating your payment!");
                window.location.reload(true);
                //  console.log(result);
            },
            onError: function(result){
                /* You may add your own implementation here */
                alert("payment failed!");
                //  console.log(result);
            },
            // onClose: function(){
            //     /* You may add your own implementation here */
            //     alert('you closed the popup without finishing the payment');
            // }
        })
    });
    </script>


    
    @if (session('paynow'))
        <script>
            window.snap.pay('{{$snapToken}}', {
            onSuccess: function(result){
                /* You may add your own implementation here */
                // window.location.href = '/invoice/{{$order->id}}'
                window.location.href = `/payment/checkout/${result.order_id}`;
                // alert("payment success!");
                // console.log(result);
            },
            onPending: function(result){
                /* You may add your own implementation here */
                // alert("wating your payment!");
                window.location.reload(true);
                //  console.log(result);
            },
            onError: function(result){
                /* You may add your own implementation here */
                alert("payment failed!");
                //  console.log(result);
            },
            // onClose: function(){
            //     /* You may add your own implementation here */
            //     alert('you closed the popup without finishing the payment');
            // }
        })
        </script>
    @endif
@endsection

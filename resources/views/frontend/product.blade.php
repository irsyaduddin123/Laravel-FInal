{{-- bang rozir --}}
@extends('layouts.app')

@section('title',$category->name.'- GearGeek Hub')

@section('content')
<div class="py-4 container maxWidth">
    <div class="subnav hidden-on-phone justify-start pt-3 gap-3">
        <div class="linkcate">
            <p class="text-warning">Product > {{$category->name}}</p>
        </div>
    </div>
    <h1 class="text-center mt-2 text-white pt-5">Category : <span style="color: #FE9900">{{ $category->name }}</span></h1>
        
    <div class="container ">
        <a href="{{ url('product/') }}" class="btn btn-warning">Kembali</a>
    </div>
    @if (count($products) > 0)
            <div class="row justify-content-center align-items-center" >
                <div class="py-3">
                    <div class="container">
                        <div class="row">

                            @foreach ($products as $product)
                                {{-- Card Box --}}
                                <div class="col-md-3">
                                    <div class="wsk-cp-product">
                                        <div class="wsk-cp-img">
                                            @php
                                                $imgDecode = json_decode($product->image)
                                            @endphp
                                            <a href="{{ url('product/'.$product->category->slug.'/'.$product->slug) }}">
                                                <img src="{{ asset($imgDecode[0]->name) }}" alt="{{ $product->name }}" class="img-responsive" />
                                            </a>
                                        </div>
                                        <div class="wsk-cp-text">
                                            <a href="{{ url('product/'.$product->category->slug.'/'.$product->slug) }}">
                                                <div class="category">
                                                    <span>{{ $product->category->name}}</span>
                                                </div>
                                            </a>
                                            <div class="title-product">
                                                <a href="{{ url('product/'.$product->category->slug.'/'.$product->slug) }}" style="color: white">
                                                    <h3>{{ $product->name }}</h3>
                                                </a>
                                            </div>
                                            <div class="description-prod">
                                                <p>{{ $product->deskripsi }}</p>
                                            </div>
                                            <div class="card-footer">
                                                <div class="d-flex justify-content-center">
                                                    <div class="wcf-left"><span class="price"><small>Rp </small>{{ number_format($product->price, 0, ',', '.') }}</span></div>
                                                </div>
                                                {{-- <div class="wcf-right">
                                                    <a href="{{ url('product/'.$product->id) }}" class="buy-btn">
                                                        <i class="fa-solid fa-cart-shopping"></i>
                                                    </a>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Card Box --}}
                            @endforeach

                        </div>
                    </div>
                </div>
        @else
                <div class="text-center pt-5">
                    <h4 style="color: white">No Products</h4>
                </div>
                <!-- End Card Box -->
            </div>
        @endif
</div>
@endsection

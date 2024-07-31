{{-- bang rozir --}}

@extends('layouts.app')

@section('title','Category - GearGeek Hub')

@section('content')
<div class="py-4 container maxWidth">
    <div class="subnav hidden-on-phone justify-start pt-3 gap-3">
        @foreach ($categories as $category)

        <div class="linkcate">
            <a  href="{{url('product/'.$category->slug)}}" class="text-white">{{$category->name}}</a>
        </div>
        @endforeach

    </div>
    <div class="dropdown drop mt-5 ">
        <a class="btn btn-sm btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Category Product
        </a>

        <ul class="dropdown-menu">
            @foreach ($categories as $category)
                <li><a class="dropdown-item" href="{{ url('product/'.$category->slug) }}">{{ $category->name }}</a></li>

            @endforeach

        </ul>
    </div>
    <!-- Content Produk -->
    <div class="container">
        <div class=" row mt-5 pt-3">
            @foreach ($latestProducts as $product)
                <div class=" col-md-3 mb-5">
                    <div class="card mx-auto text-white rounded" style="background-color: #3B3B3B">
                        <img src="{{ json_decode($product->image)[0]->name }}" class="card-img-top" style="height: 250px" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}
                                <span class="badge bg-success">Brand New</span>
                            </h5>
                            <a href="{{ url('product/'.$product->category->slug.'/'.$product->slug) }}" class="btn "style="background-color: #FE9900">Go somewhere</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row justify-content-center align-items-center mt-5 " >
        <!-- Card Box -->
        <div class="shell" >
            <div class="container">
                <div class="row">

                    @foreach ($categories as $category)
                    {{-- Card Box --}}
                    <div class="col-md-6">
                        <div class="wsk-cp-product">
                            <a href="{{ url('product/'.$category->slug) }}">
                                <div class="wsk-cp-img">
                                    <img src="{{ asset("$category->image") }}" alt="{{ $category->image }}" class="img-responsive" />
                                </div>
                                <div class="wsk-cp-text">
                                    <div class="title-product">
                                        <h3>{{ $category->name }} ({{ count($category->products) }})</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- End Card Box --}}
                    @endforeach

                </div>
            </div>
        </div>
        <!-- End Card Box -->
    </div>
</div>
@endsection

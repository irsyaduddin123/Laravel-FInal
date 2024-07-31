@extends('layouts.app')
@section('style')
<link href="{{ asset('assets/lightbox/css/lightbox.css') }}" rel="stylesheet" />

@endsection
@section('content')

    <div class="imgGame" style="background-image: url('{{ asset('assets/img/gamingLarge.jpg') }}');background-size: cover;">
    </div>
    <div class="container padding pt-4">
        <div class="row d-flex justify-content-center align-items-center" style="min-height:100vh">
            <div class="col-md-6 fade-in" >
                <div>
                    <img src="{{ asset('assets/img/1.png') }}" class="img-fluid" alt="">
                </div>
                <div>
                    <img src="{{ asset('assets/img/2.png') }}" class="img-fluid" alt="">
                </div>
            </div>
            <div class="col-md-6 flexJustify fade-in" style="flex-direction: column">
                <div style="height: 200px">
                    <h3 id="element" class="textWhite text-center pt-5" ></h3>
                </div>
                <a href="{{url('/product') }}" class="d-block btn btn-warning mt-5 mx-auto" style="width: 200px;background-color:#FE9900">Order Now!</a>
            </div>
            <div class="col-md-6 mx-auto fade-in  ">
                <h1 class="text-white text-center bounce" style="font-size: 5rem; ">
                    <a href="#promotion">
                        <i style="color:#435059" class="fas fa-arrow-circle-down"></i>
                    </a>
                </h1>
            </div>
        </div>
        <div class="row  d-flex justify-content-center align-items-center"  style="min-height: 100vh">
            <div class="fade-in col-md-12"  id="promotion">
               <a href="{{ asset('assets/home/geargeekhub_1.jpg') }}" data-lightbox="roadtrip">
                   <img src="{{ asset('assets/home/geargeekhub_1.jpg') }}" style="width: 100%; height:300px" class="img-fluid rounded" alt="geargeekHub img" >
               </a>
            </div>
            <div class="fade-in col-md-12 mt-3 mb-2">
                <h1 class="text-white text-center">Our Gallery Products
                    <a href="{{ url('product') }}" class="btn btn-warning pt-2" style="background-color: #FE9900">
                        Lets Checkout
                        <i class="fas fa-shopping-bag" ></i>
                    </a>
                </h1>
            </div>

            <div class="  fade-in col-md-3 mt-1" >
               <a href="{{ asset('assets/home/geargeekhub_2.jpg') }}" data-lightbox="roadtrip">
                   <img class="rounded" src="{{ asset('assets/home/geargeekhub_2.jpg') }}" style="width: 100%; height:200px"  alt="geargeekHub img" >
               </a>
            </div>
            <div class="  fade-in col-md-3 mt-1"  >
               <a href="{{ asset('assets/home/geargeekhub_3.jpg') }}" data-lightbox="roadtrip">
                   <img class="rounded" src="{{ asset('assets/home/geargeekhub_3.jpg') }}" style="width: 100%; height:200px"  alt="geargeekHub img" >
               </a>
            </div>
            <div class="  fade-in col-md-3 mt-1" >
               <a href="{{ asset('assets/home/geargeekhub_4.jpg') }}" data-lightbox="roadtrip">
                   <img class="rounded" src="{{ asset('assets/home/geargeekhub_4.jpg') }}" style="width: 100%; height:200px"  alt="geargeekHub img" >
               </a>
            </div>
            <div class="  fade-in col-md-3 mt-1" >
               <a href="{{ asset('assets/home/geargeekhub_5.jpg') }}" data-lightbox="roadtrip">
                   <img class="rounded" src="{{ asset('assets/home/geargeekhub_5.jpg') }}" style="width: 100%; height:200px"  alt="geargeekHub img" >
               </a>
            </div>

            <div class="  fade-in col-md-6 mt-2" >
               <a href="{{ asset('assets/home/geargeekhub_6.jpg') }}" data-lightbox="roadtrip">
                   <img class="rounded" src="{{ asset('assets/home/geargeekhub_6.jpg') }}" style="width: 100%; height:250px"  alt="geargeekHub img" >
               </a>
            </div>
            <div class="  fade-in col-md-6 mt-2" >
               <a href="{{ asset('assets/home/geargeekhub_7.jpg') }}" data-lightbox="roadtrip">
                   <img class="rounded" src="{{ asset('assets/home/geargeekhub_7.jpg') }}" style="width: 100%; height:250px"  alt="geargeekHub img" >
               </a>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/lightbox/js/lightbox.js') }}"></script>

<script src="{{ asset('assets/js/typed.umd.js') }}"></script>
<script>
    var typed = new Typed('#element', {
      strings: ['Elevate Your Gaming Experience with GearGeek Hub!', 'Where Gaming Gear Meets Geek Passion!','Empowering Gamers, One Gear at a Time!'],
      typeSpeed: 70,
      loop:true,
    });
</script>
@endsection

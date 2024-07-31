{{-- bang rozir --}}
@extends('layouts.app')
@section('style')
    <link href="{{ asset('assets/lightbox/css/lightbox.css') }}" rel="stylesheet" />
@endsection
@section('title',  $products->category->name.'-'.$products->name. '- GearGeek Hub')

@section('content')
<div class="py-4 container maxWidth">
    <div class="subnav hidden-on-phone justify-start pt-3 gap-3">


        <div class="linkcate">
            <p class="text-warning">Product > {{$products->category->name}} > {{ $products->name }}</p>
        </div>


    </div>
    <div class="pt-5 mt-2 text-white text-center">
        <h3 class="pb-1">{{ $products->name }}</h3>
    </div>
    <div class="container pb-4">
        <a href="{{ url('product/'.$products->category->slug) }}" class="btn btn-warning">Kembali</a>
    </div>
    <div class="card-box-rzw">
        <div class="container py-4 px-4">
            @if (session('message'))
                <script>
                    Swal.fire({
                        title: '{{ session('message')['title'] }}',
                        text: '{{ session('message')['text'] }}',
                        icon: '{{ session('message')['icon'] }}',
                    });
                </script>
            @endif
            <div class="row">
                <div class="col-sm-5">
                    <div class="square-image">
                        @foreach (json_decode($products->image) as $image)
                            <a href="{{ asset($image->name) }}" data-lightbox="roadtrip">
                                <div class="square-image">
                                    <img src="{{ asset(json_decode($products->image)[0]->name) }}" alt="">
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="row pt-3">
                        @foreach (json_decode($products->image) as $key => $image)
                            @if ($key > 0 && $key <= 4)
                                <div class="col-sm-3">
                                    <div class="square-image-child">
                                        <a href="{{ asset($image->name) }}" data-lightbox="roadtrip">
                                            <img src="{{ asset($image->name) }}" alt="">
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-7">
                    <small>Category : {{ $products->category->name }}</small>
                    <h5 class="pt-3">Deskripsi : </h5>
                    <p>{{ $products->deskripsi }}</p>
                    <p class="mb-4 mt-2">Stok : {{ $products->stok }}</p>
                    <h4><small id="harga_produk">{{ $products->price }}</small></h4>
                    <form action="{{ url('addtocart/'.$products->id) }}" method="post">
                        @csrf
                        <div class="btn-body pt-3">
                            <span class="pqt-minus">-</span>
                            <button class="cart-button-rzw clicked">
                                <input type="hidden" name="jumlah" id="jumlah" value='1' readonly>
                                <span class="added">1</span>
                            </button>
                            <span class="pqt-plus">+</span>
                        </div>
                        @if ($products->stok == 0)
                            <button type="button" class="btn btn-secondary mt-3">Stok habis</button>
                        @else
                            <button type="submit" class="bubbly-button" id="add_to_card">Add To Cart</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var cartButtons = document.querySelectorAll('.cart-button-rzw');
    var card_value = document.querySelector(".added");
    var pqtplus = document.querySelector(".pqt-plus");
    var pqtminus = document.querySelector(".pqt-minus");
    var jumlah = document.getElementById('jumlah');
    var produk_id = document.getElementById('produk_id');
    var harga_produk = document.getElementById('harga_produk');
    var harga_produk_satu = Number(harga_produk.textContent);
    var cartvalue = 1;

    harga_produk.textContent =  formatRupiah(harga_produk_satu * card_value.textContent)

    cartButtons.forEach(button => {
        button.addEventListener('click', cartClick);
    });
    function cartClick() {
        let button = this;
        button.classList.add('clicked');
        card_value.textContent = 1;
        cartvalue = 1;
        updateValueInput()
    }

    pqtplus.addEventListener('click', function(){
        if(card_value.nodeValue <= 0){
            card_value.textContent = cartvalue +=1;
        }
        updateValueInput()
    });

    pqtminus.addEventListener('click', function(){
        if(Number(card_value.innerText) - 1 >= 1){
            card_value.textContent = cartvalue -=1;
        }
        updateValueInput()
    });

    function updateValueInput() {
        jumlah.value = card_value.textContent;
        harga_produk.textContent =  formatRupiah(harga_produk_satu * card_value.textContent)
    }

    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    var animateButton = function(e) {
        e.preventDefault;
        //reset animation
        e.target.classList.remove('animate');

        e.target.classList.add('animate');
        setTimeout(function(){
            e.target.classList.remove('animate');
        },700);
    };

    var bubblyButtons = document.getElementsByClassName("bubbly-button");

    for (var i = 0; i < bubblyButtons.length; i++) {
        bubblyButtons[i].addEventListener('click', animateButton, false);
    }
</script>
<script src="{{ asset('assets/lightbox/js/lightbox.js') }}"></script>
@endsection

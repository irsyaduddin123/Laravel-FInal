@extends('layouts.admin')
@section('content')
<style>
    .viewImg {
        width: 100px;
        height: 100px;
    }
</style>
<a href="{{ url('admin/products') }}" class="btn btn-warning" style="color: black"><i class="fas fa-backward"></i> Kembali</a>
<div class="container text-center">
    <h1>{{ $products->name }}</h1>
</div>
@if (session('message'))
    <div class="aler alert-success p-2">{{ session('message') }}</div>
@endif
<div class="row">
    <div class="col-sm">
        <div class="my-3">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-geargeek text-white">
                            <h4 class="mb-0">Update Detail Product</h4>
                        </div>
                        <div class="card-body">
                            <form id="imageForm" action="{{ url('admin/products/'.$products->id) }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Product Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter product name" value="{{ $products->name }}">
                                    @error('name')
                                        <span class="text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Description</label>
                                    <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="5" placeholder="Enter description">{{ $products->deskripsi }}"</textarea>
                                    @error('deskripsi')
                                        <span class="text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="stok">Stock</label>
                                    <input type="number" class="form-control" name="stok" id="stok" placeholder="Enter stock quantity" value="{{ $products->stok }}">
                                    @error('stok')
                                        <span class="text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control" id="price" name="price" placeholder="Enter price" value="{{ $products->price }}">
                                    @error('price')
                                        <span class="text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="min_stok">Minimum Stock</label>
                                    <input type="number" class="form-control" id="min_stok" name="min_stok" placeholder="Enter minimum stock" value="{{ $products->min_stok }}">
                                    @error('min_stok')
                                        <span class="text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">-----Select Category-----</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ ($category->id == $products->category_id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm">
        <div class="my-3">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-geargeek text-white">
                            <h4 class="mb-0">Update Gambar <strong>{{ $products->name }}</strong></h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('admin/products/img') }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="imagePreview d-flex flex-wrap justify-content-center">
                                        @php
                                            $imgDecode = json_decode($products->image)
                                        @endphp
                                        @foreach ($imgDecode as $value)
                                            {{-- <img class="viewImg" src="{{ asset($value) }}" alt="{{ $products->name }}"> --}}
                                            <div class="image-container">
                                                <img class="viewImg" src="{{ asset($value->name) }}" alt="{{ $products->name }}">
                                                <a class="delete-btn" href="{{ url('admin/products/delimg/'.$value->id.'/'.$products->id) }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gambar">Masukan Gambar</label>
                                    <input type="file" class="form-control" id="gambar" name="image[]" multiple required>
                                    <div id="imagePreview" class="d-flex flex-wrap" style="display: none;"></div>
                                    <input type="hidden" id="imageOrder" name="image_order">
                                    <input type="hidden" id="id_produk" name="id_produk" value="{{ $products->id }}">
                                    @error('gambar.*')
                                        <span class="text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">+ Tambah Gambar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const imageInput = document.getElementById('gambar');
        const imagePreview = document.getElementById('imagePreview');
        const imageOrderInput = document.getElementById('imageOrder');
        imageInput.addEventListener('change', function() {
            imagePreview.innerHTML = '';
            const files = imageInput.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function() {
                    const img = document.createElement('img');
                    img.src = reader.result;
                    img.width = 100;
                    img.height = 100;
                    img.dataset.index = i;
                    imagePreview.appendChild(img);
                    imagePreview.style.display = 'flex';
                    updateImageOrder();
                };
                reader.readAsDataURL(file);
            }
            // updateImageOrder();
        });
        new Sortable(imagePreview, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            onSort: function () {
                updateImageOrder();
            }
        });
        function updateImageOrder() {
            console.log('Debbug : ' + JSON.stringify(imagePreview.innerHTML));
            const imageElements = imagePreview.getElementsByTagName('img');
            const order = [];
            for (let img of imageElements) {
                order.push(img.dataset.index);
            }
            imageOrderInput.value = order.join(',');
        }
        document.getElementById('imageForm').addEventListener('submit', function() {
            updateImageOrder();
        });
    });
</script>
@endsection

@extends('layouts.admin')
@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (!empty(session('error_message')['message']))
                    <div class="alert alert-{{ session('error_message')['type'] }}">
                        {{ session('error_message')['message'] }}
                    </div>
                @endif
                <div class="card shadow-sm">
                    <div class="card-header bg-geargeek text-white">
                        <h4 class="mb-0">Create Product</h4>
                    </div>
                    <div class="card-body">
                        <form id="imageForm" action="{{ route('tambah.products') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Product Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter product name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Description</label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="5" placeholder="Enter description">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <span class="text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="stok">Stock</label>
                                <input type="number" class="form-control" name="stok" id="stok" placeholder="Enter stock quantity" value="{{ old('stok') }}">
                                @error('stok')
                                    <span class="text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Enter price" value="{{ old('price') }}">
                                @error('price')
                                    <span class="text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="min_stok">Minimum Stock</label>
                                <input type="number" class="form-control" id="min_stok" name="min_stok" placeholder="Enter minimum stock" value="{{ old('min_stok') }}">
                                @error('min_stok')
                                    <span class="text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="gambar">Masukan Gambar</label>
                                <input type="file" class="form-control" id="gambar" name="image[]" multiple>
                                <div id="imagePreview" class="d-flex flex-wrap" style="display: none;"></div>
                                <input type="hidden" id="imageOrder" name="image_order">
                                @error('image.*')
                                    <span class="text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    <option value="">-----Select Category-----</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ ((int)$category->id == (int)old('category_id')) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="text-center">
                                <a href="{{ url('admin/products') }}" class="btn btn-danger">Batal</a>
                                <button type="submit" class="btn bg-geargeek">Create Product</button>
                            </div>
                        </form>
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
                // Clear previous images
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
                        img.dataset.index = i; // Store original index
                        imagePreview.appendChild(img);
                        imagePreview.style.display = 'flex';
                    };
                    reader.readAsDataURL(file);
                }

                // Update the image order input with the initial order
                // await Wait(100);
                updateImageOrder();
            });

            // Initialize SortableJS
            new Sortable(imagePreview, {
                animation: 150,
                ghostClass: 'sortable-ghost',
                onSort: function () {
                    // Update the image order input when sorting changes
                    updateImageOrder();
                }
            });

            function updateImageOrder() {
                console.log('Masuk');
                const imageElements = imagePreview.getElementsByTagName('img');
                const order = [];
                for (let img of imageElements) {
                    order.push(img.dataset.index);
                }
                imageOrderInput.value = order.join(',');
            }

            // Ensure the image order is set on form submit
            document.getElementById('imageForm').addEventListener('submit', function() {
                updateImageOrder();
            });
        });
    </script>
@endsection

@extends('layouts.admin')
@section('content')

    <h1 align="center">Reedem Code</h1>
    <div class="row">
        <div class="col-md">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="aler alert-success p-2">{{ session('success') }}</div>
            @endif
        </div>


        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="#" class="btn btn-md btn-primary" data-toggle="modal" data-target="#modaltmbh">
                        Tambah
                    </a>

                    @if (session('message'))
                        <div class="aler alert-success p-2">{{ session('message') }}</div>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Diskon</th>
                                <th>Stok</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($reedem as $key=>$r)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $r->code }}</td>
                                    <td>{{ $r->discount_percentage * 100 }}%</td>
                                    <td>{{ $r->stok_code }}</td>

                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning"data-toggle="modal"
                                            data-target="#editModal{{ $r->id }}">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#deleteModal{{ $r->id }}">Delete</a>

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Hapus --}}

    @foreach ($reedem as $r)
        <div class="modal fade" id="deleteModal{{ $r->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel{{ $r->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteModalLabel{{ $r->id }}">Confirm Delete</h1>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this reedem code?
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('reedem.destroy', $r->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- modal Edit --}}
    @foreach ($reedem as $r)
        <div class="modal fade" id="editModal{{ $r->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $r->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel{{ $r->id }}">Edit Reedem Code</h1>
                        <button type="button" class="btn-secondary" data-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <form action="{{ route('reedem.update', $r->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="code{{ $r->id }}">Code</label>
                                <input type="text" class="form-control" id="code{{ $r->id }}" name="code"
                                    value="{{ $r->code }}" placeholder="Update Code">
                            </div>
                            <div class="form-group mb-3">
                                <label for="discount_percentage{{ $r->id }}">Discount Percentage</label>
                                <input type="text" class="form-control" id="discount_percentage{{ $r->id }}"
                                    name="discount_percentage" value="{{ $r->discount_percentage * 100 }}"
                                    placeholder="Update Discount Percentage">
                            </div>
                            <div class="form-group mb-3">
                                <label for="stok_code{{ $r->id }}">Stok Code</label>
                                <input type="text" class="form-control" id="stok_code{{ $r->id }}"
                                    name="stok_code" value="{{ $r->stok_code }}"
                                    placeholder="Update Stok Code">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Tambah --}}
    <div class="modal fade" id="modaltmbh" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Reedem Code</h1>
                    <button type="button" class="btn-secondary" data-dismiss="modal" aria-label="Close">X</button>
                    </button>
                </div>
                <form action="{{ url('admin/reedem/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" id="code" name="code"
                                placeholder="Tambah Kode">
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" id="discount_percentage"
                                name="discount_percentage" placeholder="Tambah Diskon">
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" id="stok_code"
                                name="stok_code" placeholder="Stok Code">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" class="btn btn-success ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

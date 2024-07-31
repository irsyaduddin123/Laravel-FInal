@extends('layouts.admin')
@section('content')
<h1 align="center"> User Message</h1>
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
                {{-- <div class="card-header">
                    

                    @if (session('message'))
                        <div class="aler alert-success p-2">{{ session('message') }}</div>
                    @endif
                </div> --}}
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Pesan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($massage as $key=>$m)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $m->nama }}</td>
                                    <td>{{ $m->email }}</td>
                                    <td>{{ $m->pesan }}</td>

                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning"data-toggle="modal"
                                            data-target="#viewModal{{ $m->id }}">View</a>
                                    

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- modal view --}}
    @foreach ($massage as $m)
    <div class="modal fade" id="viewModal{{ $m->id }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $m->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel{{ $m->id }}">Pesan dari {{ $m->nama }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <p><strong>Nama:</strong> {{ $m->nama }}</p> --}}
                    <p><strong>Email:</strong> {{ $m->email }}</p>
                    <p><strong>Pesan:</strong></p>
                    <p>{{ $m->pesan }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    @endforeach
@endsection
@extends('layouts.admin')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.css">
@endsection
@section('content')

<!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Carts</a>
        </li>
    </ul>

<!-- Tabs Content -->
    <div class="tab-content mt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <h1 class="text-center" >Orders</h1>
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Reedem Code</th>
                    <th>Discount Percentage</th>
                    <th>Discount Amount</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order as $o)
                <tr>
                    <td>{{ $o->user->name }}</td>
                    <td>{{ $o->address }}</td>
                    <td>{{ $o->phone }}</td>
                    <td>{{ $o->reedem_code ?? 'Tidak ada' }}</td>
                    <td>{{ $o->discount_percentage * 100 .'%' ?? 'Tidak ada' }}</td>
                    <td>Rp {{ number_format($o->discount_amount) ?? 'Tidak ada' }}</td>
                    <td>Rp {{ number_format($o->total_price) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>User</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Reedem Code</th>
                    <th>Discount Percentage</th>
                    <th>Discount Amount</th>
                    <th>Total Price</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
        <h1 class="text-center" >Carts</h1>
        <table id="example2" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Product</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $c)
                <tr>
                    <td>{{ $c->user->name }}</td>
                    <td>{{ $c->product->name }}</td>
                    <td>{{ $c->product_qty }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>User</th>
                    <th>Product</th>
                    <th>Quantity</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>



@endsection

@section('scripts')
<script>
    
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#example2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
@endsection

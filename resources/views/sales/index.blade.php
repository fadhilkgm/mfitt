@extends('layouts.master')

@section('titel', 'Sales | ')
@section('content')
@include('partials.header')
@include('partials.sidebar')

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> Sales Table</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Sales</li>
            <li class="breadcrumb-item active"><a href="#">Sales Table</a></li>
        </ul>
    </div>
    <div class="tile">
        <form action="{{ route('sales.index') }}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <label for="customer_name">Customer Name</label>
                    <input type="text" placeholder="Customer Name" name="customer_name" class="form-control" value="{{ request('customer_name') }}">
                </div>
                <div class="col-md-4">
                    <label for="customer_phone">Customer Phone</label>
                    <input type="text" placeholder="Customer Phone" name="customer_phone" class="form-control" value="{{ request('customer_phone') }}">
                </div>
                <div class="col-md-4">
                    <label for="payment_method">Payment Method</label>
                    <select name="payment_method" class="form-control">
                        <option value="">All</option>
                        <option value="Cash" {{ request('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="Online" {{ request('payment_method') == 'Online' ? 'selected' : '' }}>GPay/Paytm/PhonePe</option>
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <a href="{{ route('sales.index') }}" type="submit" class="btn btn-info"> Cancel </a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
                </div>
            </div>
        </form>
        
    </div>
    <div class="tile">
        <div>
            <a class="btn btn-primary" href="{{ route('invoice.create') }}"><i class="fa fa-plus"></i> Create New Invoice</a>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Customer Phone</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>No of items</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Payment Method</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales as $sale)
                                @foreach($sale->sale as $item)
                                <tr>
                                    <td>{{ $sale->customer_name ?? 'N/A' }}</td>
                                    <td>{{ $sale->customer_phone ?? 'N/A' }}</td>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->qty }} {{ $item->product->unit }}</td>
                                    <td>{{ $item->count }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ $sale->payment_method }}</td>
                                    <td>{{ $sale->date }}</td>
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
</main>

@endsection

@push('js')
<script type="text/javascript" src="{{ asset('/') }}js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('/') }}js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $('#sampleTable').DataTable();
</script>
<script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
@endpush

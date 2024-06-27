@extends('layouts.master')

@section('title', 'Sales Invoice | ')
@section('content')
@include('partials.header')
@include('partials.sidebar')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file-text-o"></i> Sales Invoice</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Sales Invoice</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <section class="invoice m-5">
                    <div class="row mb-4">
                        <div class="col-6">
                            <!-- <h2 class="page-header"><img src="{{asset('images/logo-full.png')}}" width="200px" alt="">
                            </h2> -->
                            <h2 class="page-header">Flex Korakkath
                            </h2>
                        </div>
                        <div class="col-6">
                            <h5 class="text-right">Date: {{$invoice->date}}</h5>
                        </div>
                    </div>

                    <div class="row invoice-info">
                        <div class="col-4">From
                            <address><strong>Flex Korakkoth</strong><br>
                            Karanthur</address>
                        </div>
                        <div class="col-4">To
                            <address><strong>{{$invoice->customer->name ?? 'No name available'}}</strong>
                                <br>Phone:{{$invoice->customer->phone ?? 'No Phone number available'}}<br>
                                Place:{{$invoice->customer->place ?? 'No place available'}}
                            </address>
                        </div>
                        <div class="col-4"><b>Invoice #{{$invoice->invoice_no}}</b><br><b>Payment Due:</b> {{$invoice->created_at->format('Y-m-d')}}</div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Si No </th>
                                        <th>Product Name </th>
                                        <th>Product quantity</th>
                                        <th>Product Price</th>
                                        <th>Product Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <div style="display: none">
                                        {{$total=0}}
                                    </div>
                                    @foreach($invoice->sales as $sale)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$sale->product->name}}</td>
                                        <td>{{$sale->quantity}}</td>
                                        <td>{{$sale->product->price}}</td>
                                        <td>{{$sale->amount}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td><b>Paid</b></td>
                                        <td>{{$invoice->paid}} ₹</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td><b>Balance</b></td>
                                        <td>{{$invoice->balance}} ₹</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td><b>Discount</b></td>
                                        <td>{{$invoice->discount}} ₹</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td><b>Total</b></td>
                                        <td>{{$invoice->total}} ₹</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 d-print-none">
                            <a href="{{ route('invoice.index') }}" class="btn btn-info">Back</a>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="row d-print-none">
                                <div class="col-12 text-right">
                                    <a class="btn btn-primary" href="javascript:void(0);" onclick="printInvoice();"><i
                                            class="fa fa-print"></i> Print</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</main>


<script>
    function printInvoice() {
        window.print();
    }
</script>

@endsection
@push('js')
@endpush

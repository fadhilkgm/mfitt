@extends('layouts.master')

@section('title', 'Invoice | ')
@section('content')
    @include('partials.header')
    @include('partials.sidebar')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-file-text-o"></i> Purchase Invoice</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="#">Invoice</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <section class="invoice">
                        <div class="row mb-4">
                            <div class="col-6">
                                <h2 class="page-header"><img src="{{asset('images/logo-full.png')}}" width="200px" alt=""></h2>
                            </div>
                            <div class="col-6">
                                <h5 class="text-right">Date: {{$invoice->created_at->format('Y-m-d')}}</h5>
                            </div>
                        </div>
                        
                   <div class="row invoice-info">
                            <div class="col-4">From
                                <address><strong>Mfitt Calicut</strong><br></address>
                            </div>
                            <div class="col-4">To
                                 <address><strong>{{$invoice->customer_name}}</strong><br>Phone: {{$invoice->customer_phone}}<br></address>
                             </div>
                            <div class="col-4"><b>Invoice #{{1000+$invoice->id}}</b><br><br><b>Order ID:</b> 4F3S8J<br><b>Payment Due:</b> {{$invoice->created_at->format('Y-m-d')}}<br><b>Account:</b> 000-12345</div> 
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>No of Items</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Amount</th>
                                     </tr>
                                    </thead>
                                    <tbody>
                                    <div style="display: none">
                                        {{$total=0}}
                                    </div>
                                    @foreach($sales as $sale)
                                    <tr>
                                        <td>{{$sale->product->name}}</td>
                                        <td>{{$sale->qty}} {{$sale->product->unit}}</td>
                                        <td>{{$sale->count}}</td>
                                        <td>{{$sale->price}}</td>
                                        <td>{{$sale->dis}}%</td>
                                        <td>{{$sale->amount}}</td>
                                        <div style="display: none">
                                            {{$total +=$sale->amount}}
                                        </div>
                                     </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td><b>Total</b></td>
                                        <td><b class="total">{{$total}}</b></td>
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
                                        <a class="btn btn-primary" href="javascript:void(0);" onclick="printInvoice();"><i class="fa fa-print"></i> Print</a>
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






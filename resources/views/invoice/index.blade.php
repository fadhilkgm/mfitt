

@extends('layouts.master')

@section('titel', 'Invoice | ')
@section('content')
    @include('partials.header')
    @include('partials.sidebar')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> Invoices Table</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">Invoice</li>
                <li class="breadcrumb-item active"><a href="#">Invoice Table</a></li>
            </ul>
        </div>
        <div class="">
            <a class="btn btn-primary" href="{{route('invoice.create')}}"><i class="fa fa-plus"></i> Create New Invoice</a>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th>Invoice ID </th>
                                <th>Customer Name </th>
                                <th>Customer Phone</th>
                                <th>Payment Method</th>
                                <th>Date </th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                             <tbody>

                             @foreach($invoices as $invoice)
                                 <tr>
                                     <td>{{1000+$invoice->id}}</td>
                                     <td>{{$invoice->customer_name ?? "No name Available"}}</td>
                                     <td>{{$invoice->customer_phone ?? "No phone available"}}</td>
                                     <td>{{$invoice->payment_method}}</td>
                                     <td>{{$invoice->date}}</td>
                                     <td>{{$invoice->total}} ₹</td>
                                     <td>
                                         <a class="btn btn-primary btn-sm" href="{{route('invoice.show', $invoice->id)}}"><i class="fa fa-eye" ></i></a>
                                         <a class="btn btn-info btn-sm" href="{{route('invoice.edit', $invoice->id)}}"><i class="fa fa-edit" ></i></a>

                                         <button class="btn btn-danger btn-sm waves-effect" type="submit" onclick="deleteTag({{ $invoice->id }})">
                                             <i class="fa fa-trash"></i>
                                         </button>
                                         <form id="delete-form-{{ $invoice->id }}" action="{{ route('invoice.destroy',$invoice->id) }}" method="POST" style="display: none;">
                                             @csrf
                                             @method('DELETE')
                                         </form>
                                     </td>
                                 </tr>
                             @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>



@endsection

@push('js')
    <script type="text/javascript" src="{{asset('/')}}js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{asset('/')}}js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script type="text/javascript">
        function deleteTag(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush

@extends('layouts.master')

@section('titel', 'Product | ')
@section('content')
@include('partials.header')
@include('partials.sidebar')

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> Product Table</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Product</li>
            <li class="breadcrumb-item active"><a href="#">Product Table</a></li>
        </ul>
    </div>
    <div class="">
        <a class="btn btn-primary" href="{{route('product.create')}}"><i class="fa fa-plus"></i> Add Product</a>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Si No</th>
                                <th>Product Name</th>
                                <th>Sales Price</th>
                                <th>Unit</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($products as $product)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->price}}</td>
                                <td>{{$product->unit}}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('product.edit', $product->id) }}"><i class="fa fa-edit"></i></a>
                                        <button class="btn btn-danger btn-sm waves-effect" type="submit"
                                            onclick="deleteTag({{ $product->id }})">
                                            <i class="fa fa-trash"></i>
                                        <form id="delete-form-{{ $product->id }}"
                                            action="{{ route('product.destroy',$product->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                            </button>
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
            confirmButtonClass: 'btn btn-success m-2',
                cancelButtonClass: 'btn btn-danger m-2',
            buttonsStyling: false,
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                document.getElementById('delete-form-' + id).submit();
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

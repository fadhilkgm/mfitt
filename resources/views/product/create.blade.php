@extends('layouts.master')

@section('title', 'Add Product | ')
@section('content')
@include('partials.header')
@include('partials.sidebar')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Add New Product</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Product</li>
            <li class="breadcrumb-item"><a href="#">Add Products</a></li>
        </ul>
    </div>

    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif

    <div class="">
        <a class="btn btn-primary" href="{{route('product.index')}}"><i class="fa fa-edit"></i> Manage Product</a>
    </div>
    <div class="row mt-2">

        <div class="clearix"></div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Product</h3>
                <div class="tile-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{route('product.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Product Name</label>
                                <input name="name" class="form-control @error('name') is-invalid @enderror" type="text"
                                    placeholder="Product Name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Unit</label>
                                <select name="unit" class="form-control unit">
                                    <option value="">Select Unit</option>
                                    <option value="M">Meter</option>
                                    <option value="In">Inch</option>
                                    <option value="Ft">Feet</option>
                                    <option value="Pc">Piece</option>
                                </select>
                                @error('unit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 selling-price-normal">
                                <label class="control-label">Price</label>
                                <input name="price"
                                    class="form-control @error('price') is-invalid @enderror" type="number"
                                    placeholder="Enter Price">
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-4 align-self-end">
                            <button class="btn btn-success" type="submit"><i
                                    class="fa fa-fw fa-lg fa-check-circle"></i>Add Product</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection
@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{asset('/')}}js/multifield/jquery.multifield.min.js"></script>
@endpush

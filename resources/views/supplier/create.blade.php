@extends('layouts.master')

@section('title', 'Supplier | ')
@section('content')
@include('partials.header')
@include('partials.sidebar')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Supplier</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Supplier</li>
            <li class="breadcrumb-item"><a href="#">Add Supplier</a></li>
        </ul>
    </div>


    <div class="">
        <a class="btn btn-primary" href="{{route('supplier.index')}}"><i class="fa fa-edit"></i> Manage Supplier</a>
    </div>
    <div class="row mt-2">

        <div class="clearix"></div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Supplier</h3>
                <div class="tile-body">
                    <form method="POST" action="{{route('supplier.store')}}">
                        @csrf
                        <div class="row">


                            <div class="form-group col-md-6">
                                <label class="control-label">Supplier Name</label>
                                <input name="name" class="form-control @error('name') is-invalid @enderror" type="text"
                                    placeholder="Enter Name of Supplier">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Supplier Phone</label>
                                <input name="phone" class="form-control @error('phone') is-invalid @enderror"
                                    type="text" placeholder="Enter supplier phone number">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="submit"><i
                                    class="fa fa-fw fa-lg fa-check-circle"></i>Add Supplier Details</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

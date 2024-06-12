@extends('layouts.master')

@section('title', 'Category | ')
@section('content')
    @include('partials.header')
    @include('partials.sidebar')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i> Edit Category</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">Category</li>
                <li class="breadcrumb-item"><a href="#">Edit Category</a></li>
            </ul>
        </div>

        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="row">
            <div class="clearix"></div>
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Category</h3>
                    <div class="tile-body">
                        <form method="POST" action="{{route('category.update', $category->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Category Name</label>
                                        <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{$category->name}}" type="text" placeholder="Enter Category Name">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Category type</label>
                                        <select name="type" class="form-control @error('name') is-invalid @enderror">
                                            <option value="">Select type</option>
                                            <option value="Pack" {{$category->type=='Pack'?'selected':''}}>Pack</option>
                                            <option value="Bottle" {{$category->type=='Bottle'?'selected':''}}>Bottle</option>
                                            <option value="Beverages" {{$category->type=='Beverages'?'selected':''}}>Beverages</option>
                                        </select>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> -->
                            </div>
                            <div class="form-group col-md-4 align-self-end">
                                <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection




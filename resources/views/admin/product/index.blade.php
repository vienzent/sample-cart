@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('partials.flash-message')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="h2">Products</p>
                <a href="{{ __url('/admin/products/create') }}" class="btn btn-danger">Add</a>
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->getID() }}</td>
                                <td>{{ $product->getName() }}</td>
                                <td>{{ $product->getPrice() }}</td>
                                <td><a href="{{ __url('/admin/products/' . $product->getID() . '/edit') }}" class="btn btn-primary btn-sm">Edit</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
@endsection

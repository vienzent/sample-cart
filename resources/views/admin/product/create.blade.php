@extends('layouts.admin')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                @include('partials.flash-message')
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <p class="h2">Add Product</p>

                <form action="{{ __url('/admin/products') }}" method="POST">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input value="{{ $_REQUEST['name'] ?? $product->getName() }}" name="name" type="text" class="form-control" id="name" />
                    </div>
                    <div class="form-group">
                        <label for="qty">Price</label>
                        <input value="{{ $_REQUEST['price'] ?? $product->getPrice() }}" name="price" type="text" class="form-control" id="price" />
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
@endsection

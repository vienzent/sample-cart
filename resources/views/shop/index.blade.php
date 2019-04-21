@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    @include('partials.flash-message')
                </div>
            </div>

            <div class="col-md-12">
                <p class="h2">Shop</p>
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th class="text-center col-md-2">ID</th>
                        <th class="text-center col-md-3">Name</th>
                        <th class="text-center col-md-2">Price</th>
                        <th class="text-center col-md-3">Qty</th>
                        <th class="text-center col-md-2">Rate</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td class="text-center">{{ $product->getID() }}</td>
                            <td class="text-center">{{ $product->getName() }} </td>
                            <td class="text-center">$ {{ number_format($product->getPrice(), 2)  }}</td>
                            <td class="text-center">
                                <form class="form-inline" action="{{ __url('/cart/' . $product->getId()) }}" method="POST">
                                    <div class="form-group">
                                        <input style="max-width: 100px;" value="0" name="qty" type="text" class="form-control input-sm" id="name" />
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">Add to cart</button>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <span class="average">
                                    {{ number_format($product->getAverageRate(), 1) }}
                                </span>
                                <select class="rate" style="display: none;"
                                        data-review-count="{{ $product->getReviewCount()  }}"
                                        data-average-rate="{{ $product->getAverageRate()  }}"
                                        data-product-id="{{ $product->getId()  }}">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                <span class="count">{{ $product->getReviewCount() }}</span> reviews
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection


@push('styles')
    <link rel="stylesheet" href="{{ __url('/css/fontawesome-stars.css') }}">
@endpush

@push('scripts')
    <script src="{{ __url('/js/jquery.barrating.min.js') }}"></script>
    <script>
        (function($, undefined){
            $('.rate').each(function(index, $el){
                $($el).barrating({
                    initialRating: $($el).data('average-rate'),
                    theme: 'fontawesome-stars',
                    onSelect: function(value, text, event){
                        let $this = this;
                        let $el = this.$elem;
                        console.log(this);
                        if (typeof(event) !== 'undefined') {
                            $.post( "{{ __url('products/')  }}" + $el.data('product-id') + "/rate", { rate: value }, function( data ) {

                                $this.readonly(true)

                                let average = +data.average;
                                let count = +data.count;

                                $el.parents('td')
                                    .find('.average').html(average.toFixed(1)).end()
                                    .find('.count').html(count).end();
                            }, "json");
                        } else {

                        }
                    }
                });
            });


        }(jQuery))
    </script>
@endpush
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    @include('partials.flash-message')
                </div>
            </div>

            <div class="col-md-8">
                <p class="h2">Cart</p>
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th class="text-center col-md-4">Name</th>
                        <th class="text-center col-md-2">Price</th>
                        <th class="text-center col-md-1">Qty</th>
                        <th class="text-center col-md-2">Total</th>
                        <th class="text-center col-md-3">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td class="text-center">{{ $item->getName() }}</td>
                            <td class="text-center">$ {{ number_format($item->getPrice(), 2) }}</td>
                            <td class="text-center">
                                <form id="form_cart_id_{{ $item->getId() }}" class="form-inline" action="{{ __url('/cart/' . $item->getId()) . '/qty' }}" method="POST">
                                    <div class="form-group">
                                        <input style="max-width: 100px;" value="{{ $item->getQty()  }}" name="qty" type="text" class="form-control input-sm" id="qty" />
                                    </div>
                                </form>
                            </td>
                            <td class="text-center">$ {{ number_format($item->getTotal(), 2) }}</td>
                            <td class="text-center">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <button form="form_cart_id_{{ $item->getId() }}" type="submit" class="btn btn-primary btn-sm">Update</button>
                                    </div>
                                    <form class="form-group" action="{{ __url('/cart/' . $item->getId()) . '/delete'}}" method="POST">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                    @if(count($items) == 0)
                        <tr>
                            <td colspan="5" class="text-center">Empty</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <p class="h2">Summary</p>

                <table class="table table-striped table-bordered table-condensed">
                    <tr>
                        <th class="h4">Sub-total:</th>
                        <td class="h4">$ {{ number_format($sub_total, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="h4">Shipping:</th>
                        <td class="h4">
                            <form id="form_checkout" class="" action="{{ __url('/checkout') }}" method="POST">
                                <input type="hidden" id="sub_total" value="{{ $sub_total }}">
                                <div class="form-group" style="margin-bottom: 0px;">
                                    <select name="shipping" id="shipping" class="form-control input-sm ">
                                        <option value="" selected disabled>Choose shipping</option>
                                        <option value="PICK_UP">Pick up ($ 0.00)</option>
                                        <option value="UPS">UPS ($ 5.00)</option>
                                    </select>
                                    <span id="help-shipping" class="help-block"></span>
                                </div>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th class="h4">Total:</th>
                        <td class="h4">$ <span id="total"></span></td>
                    </tr>
                    <tr>
                        <th class="h4">Current Balance:</th>
                        <td class="h4">$ {{ number_format($current_balance, 2) }}</td>
                    </tr>
                </table>
                {{--<div  id="checkout_error" style="display: none;" class="alert alert-danger alert-dismissible" role="alert"></div>--}}
                <button form="form_checkout" class="btn btn-danger btn-block" {{ count($items) == 0 ? "disabled" : ""  }}>PAY</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function($, undefined){
            $('#shipping').on('change', function() {

                $('#help-shipping').html('');
                $('#help-shipping').hide();
                $('#shipping').parent().removeClass("has-error");

                let type = $(this).val();
                let sub_total = +$('#sub_total').val();
                let shipping_fee = 0;
                if(type === 'UPS') {
                    shipping_fee = 5.0;
                }
                let total = sub_total + shipping_fee;
                $('#total').html(total.format(2, 3, ',', '.'));
            });

            $('#shipping').trigger('change');

            $('#form_checkout').on('submit', function(e) {
               if(!$('#shipping').val()) {
                   $('#help-shipping').html('Shipping is required');
                   $('#help-shipping').show();
                   $('#shipping').parent().addClass("has-error");
                   return false;
               }
            });
        }(jQuery))
    </script>
@endpush



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
                <p class="h2">Orders</p>
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th class="text-center">Order ID</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Total Paid</th>
                        <th class="text-center">Previous Balance</th>
                        <th class="text-center">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->getId() }}</td>
                                <td>{{ $order->getCreatedAt()->format('Y-m-d H:i:s') }}</td>
                                <td>{{ $order->getTotalPaid() }}</td>
                                <td>{{ $order->getPreviousBalance() }}</td>
                                <td>{{ $order->getStatus() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

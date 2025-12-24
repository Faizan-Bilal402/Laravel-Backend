@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Admin Dashboard</h1>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger btn-sm">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>
@stop

@section('content')

@foreach($orders as $order)
<div class="card mb-4 shadow-sm">

    {{-- ORDER BASIC INFO --}}
    <div class="card-header bg-dark text-white d-flex justify-content-between">
        <div>
            <strong>Order ID:</strong> {{ $order->id }} <br>
            <strong>User ID:</strong> {{ $order->user_id }} <br>
            <strong>Items Count:</strong> {{ $order->totalItem }}
        </div>

        <div class="text-right">
            <span class="badge badge-info">
                {{ strtoupper($order->payment_mode) }}
            </span>

            @if($order->payment_status)
                <span class="badge badge-success">Paid</span>
            @else
                <span class="badge badge-warning">Pending</span>
            @endif
        </div>
    </div>

    {{-- ITEMS TABLE --}}
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead class="thead-light">
                <tr>
                    <th>Item ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Cover</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->order_item as $item)
                <tr>
                    <td>{{ $item->item_id }}</td>
                    <td><strong>{{ $item->name }}</strong></td>
                    <td>{{ $item->description ?? '-' }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>
                        @if($item->cover)
                            <img src="{{ $item->cover }}" width="50">
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ORDER TOTALS (DIRECT FROM DB) --}}
    <div class="card-footer bg-light">
        <div class="row">
            <div class="col-md-8">
                <strong>Address:</strong><br>
                {{ $order->address }}<br><br>

                <small>
        <strong>Phone:</strong>
        {{ $order->user->phone ?? '-' }}
    </small><br><br>

                <strong>Transaction ID:</strong>
                {{ $order->transaction_id ?? '-' }}<br>

                <strong>Created At:</strong>
                {{ $order->created_at->format('d M Y, h:i A') }}
            </div>

            <div class="col-md-4 text-right">
                <p>Total Price: ${{ number_format($order->totalPrice, 2) }}</p>
                <p>Delivery: ${{ number_format($order->total_delivery_charge, 2) }}</p>
                <p>Tax: ${{ number_format($order->tax, 2) }}</p>
                <p>Discount: ${{ number_format($order->discount, 2) }}</p>

                @if($order->coupon)
                    <p>Coupon: {{ $order->coupon }}</p>
                @endif

                <hr>

                <h5>
                    Grand Total:
                    <span class="text-primary">
                        ${{ number_format($order->grandTotal, 2) }}
                    </span>
                </h5>
            </div>
        </div>
    </div>

</div>
@endforeach

@stop

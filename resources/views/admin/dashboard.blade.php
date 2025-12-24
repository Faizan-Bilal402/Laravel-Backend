@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Admin Dashboard</h1>

    {{-- Logout Button --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger btn-sm">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>
@stop

@section('content')

<p class="mb-3">View your orders and items here</p>

@foreach($orders as $order)
<div class="card mb-4 shadow-sm">

    {{-- Order Header --}}
    <div class="card-header bg-dark text-white d-flex justify-content-between">
        <div>
            <strong>Order #{{ $order->id }}</strong><br>
            <small>User ID: {{ $order->user_id }}</small>
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

    {{-- Items Table --}}
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead class="thead-light">
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->order_item as $item)
                <tr>
                    <td><strong>{{ $item->name }}</strong></td>
                    <td>{{ $item->description ?? '-' }}</td>
                    <td>
                        <span class="badge badge-secondary">
                            {{ $item->quantity }}
                        </span>
                    </td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>
                        @if($item->cover)
                            <img src="{{ $item->cover }}" width="50" class="img-thumbnail">
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Order Footer --}}
    <div class="card-footer bg-light">
        <div class="row">
            <div class="col-md-8">
                <strong>Delivery Address:</strong><br>
                {{ $order->address }}
            </div>

            <div class="col-md-4 text-right">
                <p class="mb-1">Subtotal: ${{ number_format($order->totalPrice, 2) }}</p>
                <p class="mb-1">Delivery: ${{ number_format($order->total_delivery_charge, 2) }}</p>
                <p class="mb-1">Tax: ${{ number_format($order->tax, 2) }}</p>

                @if($order->coupon)
                    <p class="mb-1 text-success">
                        Coupon ({{ $order->coupon }}): 
                        -${{ number_format($order->discount, 2) }}
                    </p>
                @endif

                <h5 class="mt-2">
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

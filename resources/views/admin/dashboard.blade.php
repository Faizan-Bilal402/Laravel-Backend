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

<p class="mb-3">View your orders and items here</p>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Orders Table</h3>
    </div>

    <div class="card-body table-responsive p-0" style="max-height: 600px;">
        <table class="table table-hover table-striped table-bordered text-nowrap">
            <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Grand Total</th>
                    <th>Total Price</th>
                    <th>Delivery Charge</th>
                    <th>Tax</th>
                    <th>Coupon</th>
                    <th>Discount</th>
                    <th>Payment Mode</th>
                    <th>Payment Status</th>
                    <th>Transaction ID</th>
                    <th>Address</th>
                    <th>Items</th>
                </tr>
            </thead>

            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user_id }}</td>
                    <td>${{ number_format($order->grandTotal, 2) }}</td>
                    <td>${{ number_format($order->totalPrice, 2) }}</td>
                    <td>${{ number_format($order->total_delivery_charge, 2) }}</td>
                    <td>${{ number_format($order->tax, 2) }}</td>
                    <td>{{ $order->coupon ?? '-' }}</td>
                    <td>${{ number_format($order->discount ?? 0, 2) }}</td>
                    <td>
                        <span class="badge badge-info">
                            {{ strtoupper($order->payment_mode) }}
                        </span>
                    </td>
                    <td>
                        @if($order->payment_status)
                            <span class="badge badge-success">Paid</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>
                    <td>{{ $order->transaction_id ?? '-' }}</td>
                    <td>{{ $order->address }}</td>
                    <td>
                        <ul class="mb-0 pl-3">
                            @foreach($order->order_item as $item)
                            <li class="mb-2">
                                <strong>{{ $item->name }}</strong>
                                ({{ $item->description ?? '-' }})<br>

                                Qty:
                                <span class="badge badge-secondary">
                                    {{ $item->quantity }}
                                </span>
                                |
                                Price:
                                ${{ number_format($item->price, 2) }}

                                @if($item->cover)
                                    <br>
                                    <img src="{{ $item->cover }}"
                                         alt="{{ $item->name }}"
                                         width="50"
                                         class="img-thumbnail mt-1">
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop

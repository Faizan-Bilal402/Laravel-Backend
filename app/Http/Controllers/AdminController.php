<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // security check (optional but good)
        if (!Auth::user() || !Auth::user()->is_admin) {
            abort(403);
        }

        $orders = Order::with(['order_item', 'user'])
            ->latest()
            ->get();

        return view('admin.dashboard', compact('orders'));
    }
}

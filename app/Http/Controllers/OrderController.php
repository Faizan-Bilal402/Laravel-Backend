<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $user = $request->user();

    if (!$user) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    // ✅ ADMIN: LOAD ALL ORDERS WITH USER DATA
    $orders = Order::with([
        'order_item',
        'user:id,name,phone'
    ])->latest()->get();

    return response()->json([
        'data' => $orders
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $input = $request->all();

        $validator = Validator::make($input, [
            'grandTotal' => 'required',
            'totalItem' => 'required',
            'totalPrice' => 'required',
            'total_delivery_charge' => 'required',
            'items' => 'required|array',
            'payment_mode' => 'required',
            'address' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 422);
        }

        $data = [
            "user_id" => $user_id,
            "grandTotal" => $input['grandTotal'],
            "totalItem" => $input['totalItem'],
            "totalPrice" => $input['totalPrice'],
            "total_delivery_charge" => $input['total_delivery_charge'],
            "payment_mode" => $input['payment_mode'],
            "payment_status" => $input['payment_status'],
            "transaction_id" => $input['transaction_id'],
            "address" => $input['address'],
            "tax" => $input['tax'],
        ];

        if($request->has('coupon')){
            $data['coupon'] = $input['coupon'];
            $data['discount'] = $input['discount'];
        }

        $order = Order::create($data);

        $order_id = $order->id;
        $items = $input['items'];

        $newArray = array_map(function ($item) use ($order_id) {
            return [
                'order_id' => $order_id,
                'item_id' => $item['item_id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'cover' => $item['cover'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $items);

        $orderItems = OrderItem::insert($newArray);

        return response()->json(['success' => 1, 'message' => 'Order placed successfully']);
    }



/** admin panel */
    public function adminOrders()
{
    $orders = Order::with('order_item')->get(); // Sab orders fetch karo
    return view('admin.dashboard', compact('orders'));
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

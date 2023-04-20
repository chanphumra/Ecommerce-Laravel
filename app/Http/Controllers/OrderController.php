<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->get();
        return response()->json([
            "result" =>
            $orders
        ], 200);
    }

    public function store(Request $request)
    {
    }

    public function show(string $id)
    {
        $orders = Order::find($id);
        $order_details = OrderDetail::where('o_id', $id)->with('products')->get();
        return response()->json([
            "result" => [
                "order" => $orders,
                "details" => $order_details
            ]
        ], 200);
    }
}

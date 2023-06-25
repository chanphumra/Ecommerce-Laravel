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
        $order = new Order();
        $order->user_id = $request->user_id;
        $order->payment_method = $request->payment_method;
        $order->fullname = $request->fullname;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->status = $request->status;
        $order->total = $request->total;
        $order->save();

        return response()->json([
            "success" => true,
            "insert_id" => $order->id
        ], 200);
    }

    public function storeDetail(Request $request)
    {
        $order_detail = new OrderDetail();
        $order_detail->o_id = $request->o_id;
        $order_detail->p_id = $request->p_id;
        $order_detail->qty = $request->qty;
        $order_detail->save();
        
        return response()->json([
            "success" => true,
            "insert_id" => $order_detail->id
        ], 200);
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

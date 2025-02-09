<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderDetailResource;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // show all order
    public function index(){
        $orders = Order::select(['id','customer_name','table_no',  'status', 'total','order_date', 'order_time',])->get();
        return response(['data' => $orders], 200);
    }

    // show order
    public function show(Request $request){
        $order = Order::findOrFail($request['id']);
        return new OrderDetailResource($order);
    }

    // create order
    public function store(Request $request){
        $request->validate([
            'customer_name' => 'required|max:255',
            'table_no' => 'required|max:5|numeric|integer',
            'items' => 'required|array|min:1'
        ]);

        // manipulation data
        $data = $request->only(['customer_name', 'table_no']);
        $data['order_date'] = now()->format('Y-m-d');
        $data['order_time'] = now()->format('H:i:s');
        $data['total'] = collect($request['items'])->sum(function($item) {
            return $item['price'] * $item['qty'];
        });
        $data['waiter_id'] = $request->user()->id;
        $data['cashier_id'] = null;

        // store to table orders
        $order = Order::create($data);

        // store to table order_details
        collect($request['items'])->map(function($item) use ($order) {
            OrderDetails::create([
                'order_id' => $order['id'],
                'item_id' => $item['id'],
                'price' => $item['price'],
                'qty' => $item['qty']
            ]);
        });

       return response(['message'=> 'status ordered for ' . $request['customer_name'],'data' => $order], 201);
    }

    // update order status to ready
    public function updateReady(Request $request){
        $order = Order::findOrFail($request['id']);

        // cek apakah order statusnya ordered
        if($order->status != 'ordered'){
            return response(['message' => 'Order status must be ordered'], 400);
        }

        // update status menjadi ready
        $order->update([
            'status' => 'ready'
        ]);

        return new OrderDetailResource($order);
    }

    // update order status to paid
    public function updatePaid(Request $request){
        $order = Order::FindOrFail($request['id']);

        if($order['status'] != 'ready'){
            return response(['message' => 'Order status must be ready'], 400);
        }

        $order->update([
            'status' => 'paid',
            'cashier_id' => $request->user()->id
        ]);

        return new OrderDetailResource($order);
    }
}
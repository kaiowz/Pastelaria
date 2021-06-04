<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suborder;
use App\Models\Order;
use App\Models\Pastry;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderDetailsMail;

class OrderController extends Controller
{
    private $loggedUser;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->loggedUser = auth()->user();
    }

    public function index($id = false){
        if (!$id){
            $orders = Order::where('user_id', $this->loggedUser->id)
                ->where('isDeleted', false)
                ->get();
            return response()->json(['result' => $orders], 200);
        }else{
            $order = Order::find($id);
            if (!$order) return response()->json(['error'=>'Id inválido'], 400);
            return response()->json(['result' => $order], 200);
        }
    }

    public function create(Request $req){
        $pastriesIds = $req->input('pastries');

        $newOrder = new Order();
        $newOrder->user_id = $this->loggedUser->id;
        $newOrder->save();

        foreach($pastriesIds as $pastry){
            $newSubOrder = new Suborder();
            $newSubOrder->order_id = $newOrder->id;
            $newSubOrder->pastry_id = $pastry;
            $newSubOrder->save();
        }

        $order = Order::with('suborder')->find($newOrder->id);

        $pastries = [];
        foreach ($order->suborder as $suborder){
            $pastry = Pastry::where('id', $suborder->pastry_id)->first();
            $pastries[] = $pastry;
        }

        Mail::to($this->loggedUser->email)->send(new OrderDetailsMail($this->loggedUser->name, $order, $pastries));

        return response()->json(['result' => "Pedido registrado com sucesso!"], 200);
    }

    public function update(Request $req, $id){
        $_order = Order::find($id);
        if (!$_order) return response()->json(['error' => "ID inválido"], 400);
        $_order->user_id = $this->loggedUser->id;

        $pastriesIds = $req->input('pastries');

        $subOrders = Suborder::where('order_id', $_order->id)->get();

        foreach($subOrders as $subOrder){
            $subOrder->delete();
        }

        foreach($pastriesIds as $pastry){
            $subOrder = new Suborder();
            $subOrder->order_id = $_order->id;
            $subOrder->pastry_id = $pastry;
            $subOrder->save();
        }

        $order = Order::with('suborder')->find($_order->id);

        $pastries = [];
        foreach ($order->suborder as $suborder){
            $pastry = Pastry::where('id', $suborder->pastry_id)->first();
            $pastries[] = $pastry;
        }

        Mail::to($this->loggedUser->email)->send(new OrderDetailsMail($this->loggedUser->name, $order, $pastries));

        return response()->json(['result' => "Pedido registrado com sucesso!"], 200);
    }

    public function delete($id = false){
        $order = Order::find($id);
        if (!$order) return response()->json(['error'=>"Id inválido"]);

        $order->isDeleted = true;
        $order->save();

        return response()->json(['result' => "Pedido deletado com sucesso"], 200);
    }
}

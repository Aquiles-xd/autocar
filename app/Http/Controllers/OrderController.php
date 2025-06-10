<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;


class OrderController extends Controller
{
    public function store(Request $request){
        $user = Auth::user();
        $array = [];
        $data = $request->all();

        $validator = Validator::make($data, [
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        try{

            DB::beginTransaction();

            $newOrder = new Order();
            $newOrder->user_id = $user->id;
            $newOrder->product_id = $data['product_id'];
            $newOrder->amount = $data['amount'];
            $newOrder->save();

            DB::commit();

            return response()->json(['message' => 'Pedido criado com sucesso.'], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['error' => 'Erro ao criar  pedido: ' . $e->getMessage()], 500);
        }

    }
    public function getMyOrders(Request $request)
{
    $user = Auth::user();

    $orders = $user->orders()->with('product')->get();

    return response()->json([
        'success' => true,
        'orders' => $orders
    ]);
}
}

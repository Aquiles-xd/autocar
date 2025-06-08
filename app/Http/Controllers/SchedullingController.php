<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Schedulling;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SchedullingController extends Controller
{

    public function getByProduct(Request $request)
    {
        $user_id = Auth::id();
        $schedullings = Schedulling::where('product_id', $request->product_id)->get();
        $product = Product::where('user_id', $user_id)->where('id', $request->product_id)->first();

        if($user_id == $product->user_id){
            if ($schedullings->isEmpty()) {
                        return response()->json([
                            'message' => 'Nenhum agendamento encontrado para este produto.',
                            'schedullings' => []
                        ], 200);
                    }

                    return response()->json([
                        'message' => 'Agendamentos encontrados.',
                        'schedullings' => $schedullings
                    ], 200);
                }
                else{
            return response()->json(['message' => 'Usuário não encontrado'], 400);
            die;
        }

    }
        
    public function schedule(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'date'       => 'required|date',
        ]);

        $schedulling = new Schedulling();
        $schedulling->product_id = $validated['product_id'];
        $schedulling->date = $validated['date'];
        $schedulling->status = 'pendente';
        $schedulling->save();

        return response()->json([
            'message' => 'Agendamento criado com sucesso.',
            'data' => $schedulling
        ], 201);
    }

    public function accept(Request $request)
    {
        $user_id = Auth::id();
        $schedulling = Schedulling::find($request->id);

        if (!$schedulling) {
            return response()->json(['message' => 'Agendamento não encontrado.'], 404);
        }
        if($user_id == $product->user_id){
            $schedulling->status = 'em progresso';
            $schedulling->save();
        }else{
            return response()->json(['message' => 'Usuário não encontrado'], 400);
        }

       

        return response()->json(['message' => 'Agendamento em progresso.', 'data' => $schedulling]);
    }

    public function finish(Request $request)
    {
        $user_id = Auth::id();
        $schedulling = Schedulling::find($request->id);
        $product = Product::find($schedulling->product_id);

        if (!$schedulling) {
            return response()->json(['message' => 'Agendamento não encontrado.'], 404);
        }

        if($user_id == $product->user_id){
            $schedulling->status = 'finalizado';
            $schedulling->save();
            return response()->json(['message' => 'Agendamento finalizado com sucesso.', 'data' => $schedulling], 200);
        }else{
            return response()->json(['message' => 'Usuário não encontrado'], 400);
        }

    }

    public function destroy(Request $request)
    {
        $user_id = Auth::id();
        $schedulling = Schedulling::find($request->id);
        $product = Product::find($schedulling->product_id);

        if (!$schedulling) {
            return response()->json(['message' => 'Agendamento não encontrado.'], 400);
        }

        if($user_id == $product->user_id){
             $schedulling->delete();
              return response()->json(['message' => 'Agendamento deletado com sucesso.'], 200);
        }else{
            return response()->json(['message' => 'Usuário não encontrado'], 400);
        }
        
    }

}

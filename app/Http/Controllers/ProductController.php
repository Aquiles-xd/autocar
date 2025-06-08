<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;


class ProductController extends Controller
{
    public function store(Request $request){
        $user = Auth::user();
        $array = [];

        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'amount' => 'required',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        try{

            DB::beginTransaction();

            $newProduct = new Product();
            $newProduct->user_id = $user->id;
            $newProduct->category_id = $data['category'];
            $newProduct->name = $data['name'];
            $newProduct->amount = $data['amount'];
            $newProduct->description = $data['description'];
            $newProduct->type = $data['type'];
            $newProduct->mark = $data['mark'];
            $newProduct->model = $data['model'];
            $newProduct->location = $data['location'];
            $newProduct->img = $data['img'];
            $newProduct->save();

            DB::commit();

            return response()->json(['message' => 'Produto criado com sucesso.'], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['error' => 'Erro ao criar  produto: ' . $e->getMessage()], 500);
        }
        
    }

    public function edit(Request $request){
        $user = Auth::user();
        $array = [];

        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'amount' => 'required',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        try{

            DB::beginTransaction();

            $product = Product::find($request->id);

            if($user->id == $product->user_id){
                $product->category_id = $data['category'];
                $product->name = $data['name'];
                $product->amount = $data['amount'];
                $product->description = $data['description'];
                $product->type = $data['type'];
                $product->mark = $data['mark'];
                $product->model = $data['model'];
                $product->location = $data['location'];
                $product->img = $data['img'];
                $product->save();
            }else{
                DB::rollback();
                return response()->json(['error' => 'Erro ao editar produto: ' . $e->getMessage()], 500);
            }

            DB::commit();

            return response()->json(['message' => 'Produto editado com sucesso.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Erro ao editar produto: ' . $e->getMessage()], 500);
            
        }
        


    }
    public function destroy(Request $request){
        $user = Auth::user();
        $array = [];

        $data = $request->all();
        try{

            DB::beginTransaction();

            $product = Product::find($request->id);

            if($user->id == $product->user_id){
                $product->delete();
            }else{
                DB::rollback();
                return response()->json(['error' => 'Erro ao editar produto: ' . $e->getMessage()], 500);
            }

            DB::commit();

            return response()->json(['message' => 'Produto deletado com sucesso.'], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['error' => 'Erro ao deletar produto: ' . $e->getMessage()], 500);
        }
        


    }
}

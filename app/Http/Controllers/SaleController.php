<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


class SaleController extends Controller
{
    //購入
    public function purchase(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['message' => '商品が存在しません'], 404);
        }
        if ($product->stock < $quantity) {
            return response()->json(['message' => '商品が在庫不足です'], 400);
        }

        DB::beginTransaction();

        try {
            $product->stock -= $quantity;
            $product->save();


            $sale = new Sale([
                'product_id' => $productId,
            ]);

            $sale->save();

            DB::commit();

            return response()->json(['message' => '購入成功']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => '購入成功'], 500);
        }
    }
}



    // public function purchase(Request $request, $id)
    // {
    //     $quantity = $request->input('quantity');

    //     DB::beginTransaction();

    //     try {
    //         商品の在庫数をチェック
    //         $product = Product::find($id);
    //         if ($product->stock < $quantity) {
    //             throw new \Exception('在庫が不足しています。');
    //         }

    //         購入処理の実行
    //         $sale_model = new Sale();
    //         $message = $sale_model->purchase($quantity, $id);

    //         在庫数の減算
    //         $product->stock -= $quantity;
    //         $product->save();

    //         DB::commit();
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return response()->json([
    //             'error' => $e->getMessage()
    //         ], 400);
    //     }

    //     return response()->json([
    //         'message' => $message
    //     ]);

    // public function purchase(Request $request, $id)
    // {
    //     $quantity = $request->input('quantity');

    //     DB::beginTransaction();

    //     try {
    //         $sale_model = new Sale();
    //         $message = $sale_model->purchase($quantity, $id);
    //         DB::commit();
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return back();
    //     }

    //     return response()->json([
    //         'message' => $message
    //     ]);
    // }
// }

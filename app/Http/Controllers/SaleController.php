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

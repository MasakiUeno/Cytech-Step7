<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;

class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        $productId = $request->input('product_id');
        if (!$productId) {
            return response()->json(['error' => '商品IDが必要です'], 400);
        }

        DB::beginTransaction();
        try {
            $product = Product::lockForUpdate()->find($productId);
            if (!$product) {
                return response()->json(['error' => '商品が見つかりません'], 404);
            }
            if ($product->stock <= 0) {
                return response()->json(['error' => '在庫がありません'], 422);
            }

            Sale::create([
                'product_id' => $product->id,
            ]);

            $product->stock -= 1;
            $product->save();

            DB::commit();

            return response()->json([
                'message' => '購入成功',
                'product_name' => $product->product_name,
                'remaining_stock' => $product->stock
            ],200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => '購入処理に失敗しました'], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function all(Request $request): JsonResponse
    {
        try {
            $limit = $request->input('limit', 6);
            $name = $request->input('name');
            $showProduct = $request->input('show_product', false);

            $categories = ProductCategory::query();

            if ($name) {
                $categories->where('name', 'like', '%' . $name . '%');
            }

            if ($showProduct) {
                $categories->with('products');
            }

            return response()->json([
                'status' => 'success',
                'data' => $categories->paginate($limit)
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Terjadi kesalahan pada server',
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $category = ProductCategory::with('products')->find($id);

            if ($category) {
                return response()->json([
                    'status' => 'success',
                    'data' => $category
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Kategori Produk tidak ditemukan'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Terjadi kesalahan pada server',
            ], 500);
        }
    }
}

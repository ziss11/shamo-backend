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
    }

    public function show(string $id): JsonResponse
    {
        $category = ProductCategory::with('products')->find($id);


        if ($category) {
            return response()->json([
                'status' => 'success',
                'data' => $category
            ], 200);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Kategori Produk tidak ditemukan'
            ], 404);
        }
    }
}

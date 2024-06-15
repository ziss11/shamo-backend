<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function all(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 6);
        $name = $request->input('name');
        $description = $request->input('description');
        $tags = $request->input('tags');
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');
        $categories = $request->input('categories');

        $products = Product::with(['category', 'galleries']);

        if ($name) {
            $products->where('name', 'like', '%' . $name . '%');
        }

        if ($description) {
            $products->where('description', 'like', '%' . $description . '%');
        }

        if ($tags) {
            $products->where('tags', 'like', '%' . $tags . '%');
        }

        if ($price_from) {
            $products->where('price', '>=', $price_from);
        }

        if ($price_to) {
            $products->where('price', '<=', $price_to);
        }

        if ($categories) {
            $products->where('categories', $categories);
        }

        return response()->json([
            'status' => 'success',
            'data' => $products->paginate($limit)
        ], 200);
    }

    public function show(string $id): JsonResponse
    {
        $product = Product::with(['category', 'galleries'])->find($id);

        if ($product) {
            return response()->json([
                'status' => 'success',
                'data' => $product
            ], 200);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }
    }
}

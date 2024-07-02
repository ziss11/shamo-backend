<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Exception;

class ProductController extends Controller
{
    public function all(Request $request): JsonResponse
    {
        try {
            $limit = $request->input('limit', 6);
            $name = $request->input('name');
            $description = $request->input('description');
            $tags = $request->input('tags');
            $price_from = $request->input('price_from');
            $price_to = $request->input('price_to');
            $category = $request->input('category');

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

            if ($category) {
                $products->whereHas('category', function ($query) use ($category) {
                    $query->where('name', $category);
                });
            }

            return response()->json([
                'status' => 'success',
                'data' => $products->paginate($limit)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Terjadi kesalahan pada server',
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $product = Product::with(['category', 'galleries'])->find($id);

            if ($product) {
                return response()->json([
                    'status' => 'success',
                    'data' => $product
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Produk tidak ditemukan'
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Terjadi kesalahan pada server',
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CheckoutRequest;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function all(Request $request)
    {
        try {
            $limit = $request->input('limit', 6);
            $status = $request->input('status');

            $transactions = Transaction::with(['details.product'])->where('user_id', Auth::user()->id);

            if ($status) {
                $transactions->where('status', $status);
            }

            return response()->json([
                'status' => 'success',
                'data' => $transactions->paginate($limit),
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
            $transaction = Transaction::with('details.product')->find($id);

            if ($transaction) {
                return response()->json([
                    'status' => 'success',
                    'data' => $transaction
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Transaksi tidak ditemukan'
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Terjadi kesalahan pada server',
            ], 500);
        }
    }

    public function checkout(CheckoutRequest $request): JsonResponse
    {
        try {
            $transaction = Transaction::create([
                'user_id' => Auth::user()->id,
                'address' => $request->address,
                'total_price' => $request->total_price,
                'shipping_price' => $request->shipping_price,
                'status' => $request->status,
            ]);

            foreach ($request->items as $product) {
                TransactionDetail::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $product['id'],
                    'transaction_id' => $transaction->id,
                    'quantity' => $product['quantity'],
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil',
                'data' => $transaction->load('details.product')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

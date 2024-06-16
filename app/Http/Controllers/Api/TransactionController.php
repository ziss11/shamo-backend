<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
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
}

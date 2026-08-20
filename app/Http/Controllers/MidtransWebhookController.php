<?php

namespace App\Http\Controllers;

use App\Services\Payment\PaymentWebhookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class MidtransWebhookController extends Controller
{
    public function __invoke(Request $request, PaymentWebhookService $webhookService): JsonResponse
    {
        try {
            $webhookService->handle($request->all());
        } catch (Throwable $e) {
            Log::error('Midtrans webhook processing failed: '.$e->getMessage());

            // Tetap balikin 200 supaya Midtrans tidak retry berkali-kali untuk
            // payload yang memang tidak valid/signature salah — tapi untuk
            // error lain (mis. DB down), sebaiknya balikin 500 agar Midtrans
            // retry otomatis. Di sini kita generalisasi jadi 200 + log,
            // silakan disesuaikan kalau perlu retry behavior yang lebih ketat.
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 200);
        }

        return response()->json(['status' => 'ok']);
    }
}
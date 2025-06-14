<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostnetService;
use Exception;

class PosnetController extends Controller
{
    /**
     * Register a new card.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerCard(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|in:VISA,AMEX',
            'bank' => 'required|string',
            'number' => 'required|digits:16',
            'limit' => 'required|numeric|min:0',
            'dni' => 'required|numeric',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'type' => 'in:credit,debit',
        ]);

        try {
            $posnet = new PostnetService();
            $card = $posnet->registerCard($validated);
            return response()->json(['success' => true, 'card' => $card], 201);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }

    /**
     *  Process a payment.
     * 
     *  @param \Illuminate\Http\Request $request
     *  @return \Illuminate\Http\JsonResponse
     */
    public function doPayment(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|digits:16',
            'amount' => 'required|numeric|min:0.01',
            'installments' => 'required|integer|min:1|max:6',
        ]);

        try {
            $posnet = new PostnetService();
            $ticket = $posnet->doPayment($validated['number'], $validated['amount'], $validated['installments']);
            
            return response()->json([
                'success' => true,
                'ticket' => [
                    'client' => $ticket['client'],
                    'total_amount' => $ticket['total_amount'],
                    'installment_amount' => $ticket['installment_amount'],
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }
}

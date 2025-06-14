<?php

namespace App\Services;

use Exception;
use App\Models\Card;
use App\Models\Payment;

class PostnetService
{
    // Register a new card
    public function registerCard($data)
    {
        // Validate the card if  it already exists
        if (Card::where('number', $data['number'])->exists()) {
            throw new Exception('Card already registered.');
        }

        $card = Card::create([
            'brand' => $data['brand'],
            'bank' => $data['bank'],
            'number' => $data['number'],
            'limit' => $data['limit'],
            'available' => $data['limit'],
            'dni' => $data['dni'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
        ]);

        return $card;
    }

    // Proccess a payment
    public function doPayment($number, $amount, $installments)
    {
        $card = Card::where('number', $number)->first();

        if (!$card) {
            throw new Exception('Card not found.');
        }

        // Calculate surcharge and total
        $surcharge = ($installments > 1) ? ($amount * 0.03 * ($installments - 1)) : 0;
        $total = $amount + $surcharge;

        if ($card->limit < $total) {
            throw new Exception('Insufficient limit.');
        }

        // Update limit limit
        $card->limit -= $total;
        $card->save();

        // Save  payment details
        $ticket = [
            'client' => $card->first_name . ' ' . $card->last_name,
            'total_amount' => round($total, 2),
            'installment_amount' => round($total / $installments, 2),
        ];

        Payment::create([
            'card_id' => $card->number,
            'amount' => $amount,
            'installments' => $installments,
            'surcharge' => $surcharge,
            'total' => $total,
            'ticket_data' => json_encode($ticket),
        ]);

        return $ticket;
    }
}

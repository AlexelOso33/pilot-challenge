<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosnetApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_card_and_do_payment()
    {
        // Register a new card
        $cardData = [
            'brand' => 'VISA',
            'bank' => 'TestBank',
            'number' => '1234567812345678',
            'limit' => 1000,
            'dni' => 12345678,
            'first_name' => 'John',
            'last_name' => 'Doe',
        ];

        $response = $this->postJson('/api/registerCard', $cardData);
        $response->assertStatus(201)
                 ->assertJson(['success' => true]);

        // Make a payment with the registered card
        $paymentData = [
            'number' => '1234567812345678',
            'amount' => 300,
            'installments' => 3,
        ];

        $response = $this->postJson('/api/doPayment', $paymentData);
        $response->assertStatus(200)
                 ->assertJson(['success' => true])
                 ->assertJsonStructure([
                     'ticket' => [
                         'client',
                         'total_amount',
                         'installment_amount'
                     ]
                 ]);
    }
}

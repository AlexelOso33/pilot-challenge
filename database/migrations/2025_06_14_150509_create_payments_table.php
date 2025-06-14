<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('card_id', 8)->index()->comment('Card number used for the payment');
            $table->decimal('amount', 15, 2);
            $table->unsignedTinyInteger('installments');
            $table->decimal('surcharge', 10, 2)->default(0)->comment('Total surcharge applied for paying in more than one installment');
            $table->decimal('total', 10, 2);
            $table->json('ticket_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

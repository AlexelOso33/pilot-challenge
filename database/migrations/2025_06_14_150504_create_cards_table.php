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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('brand', 20)->comment('Brand of the card (VISA, AMEX)');
            $table->string('bank', 50);
            $table->string('number', 8)->unique();
            $table->decimal('limit', 15, 2);
            $table->string('dni', 8);
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('status')->default('active');
            $table->string('type')->default('credit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};

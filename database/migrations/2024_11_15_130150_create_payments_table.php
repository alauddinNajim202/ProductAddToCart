<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('card_number')->nullable(); // Store securely (e.g., encrypted)
            $table->string('cvc')->nullable(); // Encrypted if stored
            $table->string('expiry_month')->nullable();
            $table->string('expiry_year')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending'); // 'pending', 'success', 'rejected', 'failed'
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}

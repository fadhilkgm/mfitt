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
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_invoice_no');
            $table->foreignId('supplier_id')->constrained('suppliers')->primary()->cascadeOnDelete();
            $table->integer('paid')->nullable();
            $table->integer('balance')->nullable();
            $table->enum('payment_method',['Cash','Online']);
            $table->string('total');
            $table->integer('discount');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_invoices');
    }
};

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

        $table->foreignId('order_id')
              ->unique()
              ->constrained('orders')
              ->cascadeOnDelete();

        $table->string('metode_pembayaran')->default('transfer');
        $table->string('bukti_pembayaran')->nullable();
        $table->dateTime('tanggal_bayar')->nullable();
        $table->string('status')->default('menunggu_verifikasi');

        $table->timestamps();
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

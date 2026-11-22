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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
              ->constrained('users')
              ->cascadeOnDelete();

        $table->string('kode_pesanan')->unique();
        $table->dateTime('tanggal_pesan');
        $table->decimal('total_harga', 12, 2)->default(0);
        $table->text('catatan')->nullable();
        $table->string('status')->default('menunggu_pembayaran');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
   public function down(): void
   {
    Schema::dropIfExists('orders');
    }
};

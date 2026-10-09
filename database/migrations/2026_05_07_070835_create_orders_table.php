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
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained(); // Tipe Visa (Relasi ke tabel produk)

            $table->string('booking_code')->unique(); // KODE UNIK TRACKING (misal: VISA-2026-XXXX)
            $table->string('passport_number')->nullable()->after('id');
            $table->string('country_code', 5)->nullable()->after('passport_number');
            $table->string('process_type')->nullable(); // regular / express
            $table->string('visa_type')->nullable(); // Nama visa text (opsional)

            // Menggunakan enum agar status order lebih tervalidasi di database
            $table->enum('status', ['pending', 'processing', 'approved', 'rejected', 'completed'])->default('pending');

            // Kolom tanggal pelacakan proses visa
            $table->date('submission_date')->nullable();
            $table->date('completion_date')->nullable();

            $table->text('notes')->nullable();
            $table->string('sheet_row_id')->nullable(); // ID Baris untuk sinkronisasi Google Sheets
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

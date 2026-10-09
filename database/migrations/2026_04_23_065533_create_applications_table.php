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
        Schema::create('applications', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ke tabel visa_types
        $table->foreignId('visa_type_id')->constrained();

        $table->string('full_name');
        $table->string('email');
        $table->string('passport_number');
        $table->string('status')->default('pending'); // pending, reviewed, approved, rejected
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};

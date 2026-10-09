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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // <--- PASTIKAN INI ADA
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('visa_type');
            $table->decimal('price', 15, 2);
            $table->integer('duration')->nullable();
            $table->string('processing_time')->nullable();
            $table->text('requirements')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

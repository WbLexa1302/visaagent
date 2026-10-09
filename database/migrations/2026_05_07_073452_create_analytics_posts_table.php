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
       Schema::create('analytics_posts', function (Blueprint $table) {
        $table->id();
        // Menghubungkan analytics ke tabel posts
        $table->foreignId('post_id')->constrained()->cascadeOnDelete();

        $table->integer('views_count')->default(0);
        $table->integer('unique_visitors')->default(0);
        $table->integer('shares_count')->default(0);
        $table->decimal('average_read_time', 5, 2)->default(0); // dalam menit

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics_posts');
    }
};

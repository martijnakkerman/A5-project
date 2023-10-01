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
        Schema::create('embed', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('band_id');
            $table->foreign('band_id')->references('id')->on('band');
            $table->text('embed_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embed');
    }
};

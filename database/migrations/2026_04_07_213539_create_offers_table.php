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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            //$table->string('image');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price');
            $table->integer('number')->nullable();
            $table->datetime('duration')->nullable();
            $table->decimal('price_before', 8, 2)->nullable();
            $table->decimal('price_after', 8, 2)->nullable();
            $table->integer('discount_percentage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};

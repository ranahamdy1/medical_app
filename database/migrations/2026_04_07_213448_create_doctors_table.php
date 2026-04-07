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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('speciality_id');
            $table->string('gender');
            $table->decimal('price');
            $table->datetime('duration');
            $table->integer('evaluation');
            $table->integer('year_of_exp');
            $table->boolean('is_favourite');
            $table->text('about_doctor');
            $table->string('certificate_image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};

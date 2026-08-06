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
        Schema::dropIfExists('validation_rules');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('validation_rules', function (Blueprint $table) {
            $table->id();
            $table->string('form_name')->unique();
            $table->json('rules');
            $table->json('custom_messages')->nullable();
            $table->timestamps();
        });
    }
};

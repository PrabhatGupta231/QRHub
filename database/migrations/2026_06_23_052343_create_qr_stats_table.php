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
        Schema::create('qr_stats', function (Blueprint $table) {
            $table->id();
            $table->string('qr_type');
            $table->integer('size');
            $table->integer('margin');
            $table->string('color');
            $table->string('bg_color');
            $table->string('error_correction');
            $table->boolean('logo_uploaded')->default(false);
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_stats');
    }
};

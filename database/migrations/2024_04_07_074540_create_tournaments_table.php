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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tournament_name');
            $table->string('vendor_name')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('current_stage')->nullable();
            $table->integer('current_session')->nullable();
            $table->integer('track_number');
            $table->integer('champ_number');
            $table->integer('bto_number');
            $table->string('status');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};

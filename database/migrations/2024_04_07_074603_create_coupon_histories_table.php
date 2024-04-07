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
        Schema::create('coupon_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('card_id')->nullable()->index();
            $table->foreignUuid('tournament_id')->nullable()->index();
            $table->integer('values');
            $table->integer('before_changes');
            $table->integer('after_changes');
            $table->string('type'); //credit, usage, return
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
        Schema::dropIfExists('coupon_histories');
    }
};

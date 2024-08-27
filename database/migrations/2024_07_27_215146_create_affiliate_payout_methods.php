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
        Schema::create('affiliate_payout_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->text('parameters')->nullable();
            $table->decimal('fixed_charge', 10, 2)->default(0);
            $table->decimal('charge_in_percentage', 10, 2)->default(0);
            $table->text('instructions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_payout_methods');
    }
};

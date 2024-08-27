<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('referral_payouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('affiliate_payout_method_id');
            $table->decimal('amount', 28, 8);
            $table->decimal('charge', 10, 2)->default(0);
            $table->decimal('final_amount', 28, 8);
            $table->text('requirements')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = Pending | 1 = Completed | 99 = Cancelled');
            $table->text('admin_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('referral_payouts');
    }
};

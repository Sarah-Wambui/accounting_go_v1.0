<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->after('remember_token', function (Blueprint $table) {
                $table->unsignedBigInteger('referrer_id')->nullable();
                $table->tinyInteger('referral_status')->default(0);
                $table->string('referral_token', 50)->unique()->nullable();
                $table->foreign('referrer_id')->references('id')->on('users');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referrer_id']);
            $table->dropColumn(['referrer_id', 'referral_token']);
        });
    }
};

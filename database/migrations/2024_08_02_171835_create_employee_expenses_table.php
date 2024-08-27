<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('employee_expenses', function (Blueprint $table) {
            $table->id();
            $table->datetime('trans_date');
            $table->bigInteger('employee_id')->unsigned();
            $table->string('bill_no', 191)->nullable();
            $table->string('expense_type', 191);
            $table->decimal('amount', 28, 8);
            $table->text('description')->nullable();
            $table->string('attachment', 191)->nullable();
            $table->tinyInteger('status')->default(0);

            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('business_id')->unsigned();
            $table->bigInteger('created_user_id')->nullable();
            $table->bigInteger('updated_user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('employee_expenses');
    }
};

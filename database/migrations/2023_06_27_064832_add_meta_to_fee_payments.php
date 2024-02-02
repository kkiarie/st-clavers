<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fee_payments', function (Blueprint $table) {
            //
            $table->integer('mpesa_status')->nullable();
            $table->string('mpesa_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('CheckoutRequestID')->nullable();
            $table->datetime('mpesa_payment_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fee_payments', function (Blueprint $table) {
            //
        });
    }
};

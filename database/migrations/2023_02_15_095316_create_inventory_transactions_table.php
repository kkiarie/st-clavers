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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();

            $table->integer('transaction_type')->nullable();
            $table->integer('procurements_id')->nullable();
            $table->integer('inventory_masters_id')->nullable();
            $table->integer('stock')->nullable();
            $table->integer('approved_by')->nullable();
            $table->integer('requested_by')->nullable();
            $table->datetime('approval_date')->nullable();
            $table->datetime('request_date')->nullable();
            $table->integer('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_transactions');
    }
};

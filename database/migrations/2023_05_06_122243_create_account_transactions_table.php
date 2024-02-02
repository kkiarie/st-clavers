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
        Schema::create('account_transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount',15,2)->nullable();
            $table->integer('cashier_id')->nullable();
            $table->integer('source')->nullable();
            $table->integer('destination')->nullable();
            $table->integer('transaction_type')->nullable();
            $table->integer('transaction_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('allocation_type')->nullable();
            $table->integer('nature')->nullable();
            $table->text('source_tag')->nullable();
            $table->text('destination_tag')->nullable();
            $table->date('transaction_date')->nullable();  
            $table->integer('debit')->nullable();  
            $table->integer('credit')->nullable();  
            $table->integer('cashier_ledger')->nullable();  
            $table->integer('created_by')->nullable();  
             $table->integer('updated_by')->nullable();
             $table->integer('status')->nullable();
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
        Schema::dropIfExists('account_transactions');
    }
};

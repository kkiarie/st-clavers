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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount',15,2)->nullable();
            $table->integer('status')->nullable();
            $table->integer('ledger_code_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->integer('source')->nullable();
            $table->integer('destination')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('approved_by')->nullable();
            $table->datetime('approval_date')->nullable();
            $table->datetime('transaction_date')->nullable();
            $table->string('file')->nullable();
            $table->string('description')->nullable();
            $table->string('notes')->nullable();
            $table->string('source_tag')->nullable();
            $table->string('destination_tag')->nullable();
            $table->integer('allocation_type')->nullable();
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
        Schema::dropIfExists('payments');
    }
};

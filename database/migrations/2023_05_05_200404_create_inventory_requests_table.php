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
        Schema::create('inventory_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('approved_by')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('received_by')->nullable();
            // $table->integer('approved_by')->nullable();
            $table->integer('requested_by')->nullable();
            $table->datetime('approval_date')->nullable();
            $table->datetime('request_date')->nullable();
            $table->integer('source')->nullable();
            $table->integer('destination')->nullable();
            $table->integer('inventory_masters_id')->nullable();
            $table->decimal('quantity',15,2)->nullable();
            $table->decimal('unit_price',15,2)->nullable();
            $table->decimal('amount',15,2)->nullable();
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
        Schema::dropIfExists('inventory_requests');
    }
};

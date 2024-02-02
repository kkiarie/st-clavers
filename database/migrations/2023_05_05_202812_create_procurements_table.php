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
        Schema::create('procurements', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount',15,2)->nullable();
            $table->decimal('procure_amount',15,2)->nullable();
            $table->decimal('unit_price',15,2)->nullable();
            $table->string('rfp_code')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->integer('inventory_masters_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('lpo_id')->nullable();
            $table->integer('approved_by')->nullable();
            $table->integer('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->integer('updated_by')->nullable();
            $table->datetime('approval_date')->nullable();
            $table->datetime('cancelation_date')->nullable();
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
        Schema::dropIfExists('procurements');
    }
};

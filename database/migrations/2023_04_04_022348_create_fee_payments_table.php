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
        Schema::create('fee_payments', function (Blueprint $table) {
            $table->id();

            $table->integer('academic_year')->nullable();
            $table->integer('fee_structure_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('term_id')->nullable();
            $table->integer('stream_id')->nullable();
            $table->integer('student_id')->nullable();
            $table->integer('fee_structure_item_id')->nullable();
            $table->integer('payment_mode_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->decimal('amount',15,2)->nullable();
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
        Schema::dropIfExists('fee_payments');
    }
};

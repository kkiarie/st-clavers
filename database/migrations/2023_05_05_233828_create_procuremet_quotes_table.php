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
        Schema::create('procuremet_quotes', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount',15,2)->nullable();
            $table->integer('status')->nullable();
            $table->integer('procurements_id')->nullable();
            $table->integer('supplier_id')->nullable();
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
        Schema::dropIfExists('procuremet_quotes');
    }
};

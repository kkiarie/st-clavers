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
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
             $table->string('title')->nullable();
             $table->string('kra_pin')->nullable();
             $table->string('email_address')->nullable();
             $table->string('phone_number')->nullable();
             $table->string('physical_address')->nullable();
             $table->string('postal_address')->nullable();
             $table->integer('entity_type')->nullable();
             $table->integer('entity_code')->nullable();
             $table->integer('type')->nullable();
             $table->integer('occupation_id')->nullable();
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
        Schema::dropIfExists('entities');
    }
};

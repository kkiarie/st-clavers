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
        Schema::create('marks_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('uid')->nullable();
            $table->integer('type')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->decimal('marks',15,2)->nullable();
            $table->integer('student_id')->nullable();
            $table->integer('stream_id')->nullable();
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
        Schema::dropIfExists('marks_logs');
    }
};

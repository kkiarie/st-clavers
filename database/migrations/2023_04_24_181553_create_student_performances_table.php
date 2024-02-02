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
        Schema::create('student_performances', function (Blueprint $table) {
        $table->id();
        $table->integer('exam_item_id')->nullable();
        $table->integer('exam_id')->nullable();
        $table->integer('student_id')->nullable();
        $table->integer('subject_id')->nullable();
        $table->integer('program_id')->nullable();
        $table->integer('academic_level')->nullable();
        $table->integer('marks')->nullable();
        $table->integer('academic_year')->nullable();
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
        Schema::dropIfExists('student_performances');
    }
};

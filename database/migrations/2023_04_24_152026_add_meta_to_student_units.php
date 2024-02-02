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
        Schema::table('student_units', function (Blueprint $table) {
            //

        $table->integer('created_by')->nullable();
        $table->integer('updated_by')->nullable();
        $table->integer('subject_id')->nullable();
        $table->integer('program_id')->nullable();
        $table->integer('student_id')->nullable();
        $table->integer('academic_level')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_units', function (Blueprint $table) {
            //
        });
    }
};

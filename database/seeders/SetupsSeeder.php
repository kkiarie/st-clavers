<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SetupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data=["Roles"];
        $data=["Gender"];
        $data=["Remarks"];
        $data=["Grades"];
        $data=["Subjects"];
        $data=["Programs Categories"];
        $data=["Clasess"];
        $data=["Class Streams"];
        $data=["Academic Stages"];
        $data=["Program Units"];
        $data=["Parental Role"];
        $data=["School Fees Items"];
        $data=["Payment Mode"];

        for($x=0;$x<count($data);$x++)
        {
            DB::table('setups')->insert([
            'title' =>$data[$x],
            ]);


        }
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FeeStructure;
use App\Models\FeePayment;
use App\Models\StudentParent;
use App\Models\StudentClass;
use Illuminate\Support\Facades\Auth;
class ChildhubFunds extends Component
{
    public function render()
    {

        $StudentsList=StudentParent::where("parent_id",Auth::id())
        ->where("status",0)->get(["student_id"]);
        $Paid=0;
        $Balance=0;
        if($StudentsList)
        {

            foreach($StudentsList as $item)
            {
                $Balance+=$this->globalPayable($item->student_id);
                $Paid+=$this->globalPaid($item->student_id);
            }
        }

        
        return view('livewire.childhub-funds',compact('Paid','Balance'));
    }





    public function globalPaid($id=null)
    {


       $BalanceAmount=FeePayment::where("student_id",$id)
       ->where("status",1)->sum("amount");

       return $BalanceAmount;
    }



    public function globalPayable($id=null)
    {


        $PaymentsList= StudentClass::where("status","!=",3)
        ->where("student_id",$id)
        ->get(["year","class_id"])->toArray();
        $BalanceAmount=0;

       for($x=0;$x<count($PaymentsList);$x++)
        {
            $class_id=$PaymentsList[$x]["class_id"];
            $academic_year=$PaymentsList[$x]["year"];
            $results = FeeStructure::where("status",1)
            ->where("class_program",$class_id)
            ->where("academic_year",$academic_year)
            ->where("parent_id",0)
            ->get(["id"]);

            if($results)
            {

                foreach($results as $item)
                {
                    $BalanceAmount+=FeeStructure::where("status",1)
                    ->where("parent_id",$item->id)
                    ->sum("amount");
                }
            }

        }


        return $BalanceAmount;
    }



}

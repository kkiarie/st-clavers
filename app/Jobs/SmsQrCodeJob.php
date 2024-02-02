<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\StudentParent;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Support\Facades\URL;

class SmsQrCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    public function __construct($data)
    {
        //
        $this->data = $data;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        $record = StudentParent::where("status",0)
        ->where("student_id",$this->data->student_id)->get();

        if($record)
        {

            foreach ($record as $value) {

                $parent_name=$value->ParentData->name;                
                $parent_phone_number=$value->ParentData->phone; 
                $attedance_date=date("d-m-Y",strtotime($this->data->attendance));
                $attedance_time=date("h:i A",strtotime($this->data->attendance));
                $child=$this->data->StudentData->name;
                $url=URL::to("students-attendance-validate/".$this->data->uid."_".$value->parent_id);
                $message="Dear $parent_name,\nChild : $child\nDate : $attedance_date\nTime : $attedance_time.Click on the link below $url";               
                $this->Sms($parent_phone_number,$message);
            }
        }
    }


    public function Sms($number,$message)
    {

    $username = 'int'; // use 'sandbox' for development in the test environment
    $apiKey   = '9900aac922922643c1a34792ad1be8df2c5411b33f372192d37357486d81b16b'; // use your sandbox app API key for development in the test environment
    $AT       = new AfricasTalking($username, $apiKey);

    // Get one of the services
    $sms      = $AT->sms();

    // Use the service
    $result   = $sms->send([
    'to'      => $number,
    'message' => $message
    ]);

    }
}

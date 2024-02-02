<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\User;
use App\Models\Menu;
use App\Models\SetupConfig;
use App\Models\FeeStructure;
use App\Models\FeePayment;
use App\Models\StudentClass;
use App\Models\MpesaToken;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Http;



class MobilePaymentController extends Controller
{



    public $access_token;
    public $consumer_key;
    public $secret_key;
    public $access_token_url;
    public $BusinessShortCode;
    public $Passkey;
    public $initiate_url;
    public $SafPassword;
    public $Timestamp;



public function __construct()
{


    $this->access_token_url="https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
    $this->consumer_key="DP6UgZmkcTawy7B6osDXCJELpS9wKLLL";
    $this->secret_key="ukxk8YKszIn6sP5X";
    $this->BusinessShortCode = '174379';
    $this->Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';  
    $this->initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $this->Timestamp = date('YmdHis'); 
    $this->SafPassword= base64_encode($this->BusinessShortCode.$this->Passkey.$this->Timestamp);


    

     $mpesa= MpesaToken::where("status",0)->get()->last();
     if(!$mpesa)
     {
        $MpesaResponse = Http::withBasicAuth($this->consumer_key,$this->secret_key)
             ->get($this->access_token_url);

        $MpesaToken = new MpesaToken;
        $MpesaToken->acccess_token = $MpesaResponse["access_token"];
        $MpesaToken->status=0;
        $MpesaToken->token_time=Carbon::now()
        ->addSeconds($MpesaResponse["expires_in"])->format('Y-m-d H:i:s');;
        $MpesaToken->save();

        $this->access_token = $MpesaToken->acccess_token;
     }
    else if(strtotime($mpesa->token_time) > strtotime(date("Y-m-d H:i:s")))
    {
              $this->access_token=$mpesa->acccess_token;
    }
    else{

        $MpesaResponse = Http::withBasicAuth($this->consumer_key,$this->secret_key)
             ->get($this->access_token_url);

        $MpesaToken = new MpesaToken;
        $MpesaToken->acccess_token = $MpesaResponse["access_token"];
        $MpesaToken->status=0;
        $MpesaToken->token_time=Carbon::now()
        ->addSeconds($MpesaResponse["expires_in"])->format('Y-m-d H:i:s');;
        $MpesaToken->save();

        $this->access_token = $MpesaToken->acccess_token;

    }



}

    
    public function registerUrls()
    {
        // $response = Http::withToken( $this->access_token)->post('https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl', [
        //     'ShortCode' => '174379',
        //     'ResponseType' => 'Completed',
        //     'ConfirmationURL' => 'https://primary-school.spark-collector.net/mobile-payment-confirmation',
        //     'ValidationURL' => 'https://primary-school.spark-collector.net/mobile-payment-validation',
        //     ]);

        // return $response;



            $response = Http::withToken( $this->access_token)->post('https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate', [
            'ShortCode' => '174379',
            'CommandID' => 'CustomerPayBillOnline',
            'Amount' => 1,
            'Msisdn' => '254715295492',
            'BillRefNumber' => 1,

            ]);

        return $response;




    }
    public function paymentConfirmation(Request $request)
    {
        $record = new SetupConfig();
        $record->setup_id=15;
        $record->status=0;
        $record->title="mpesa";
        $record->description=json_encode($request);
        $record->save();
    }

    public function paymentValidation(Request $request)
    {
        $record = new SetupConfig();
        $record->setup_id=15;
        $record->status=0;
        $record->title="mpesa";
        $record->description=json_encode($request);
        $record->save();
        
    }
}

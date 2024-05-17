<?php

namespace App\Http\Controllers;
use App\Order;
use App\Http\Controllers\Controller;
use App\Util\BkashCredential;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Str;
use DB;

class CheckoutURLController extends Controller
{
    private $base_url;
    
    public function __construct()
    {
        //$this->base_url = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta';
        $this->base_url = 'https://tokenized.pay.bka.sh/v1.2.0-beta';
    }

    public function authHeaders(){
        
    $bkash = DB::table('payment_config')->where('id', 1)->first();
        
        return array(
            'Content-Type:application/json',
            'Authorization:' .$this->grant(),
            'X-APP-Key: ' . $bkash->user_app_key
        );
    }
         
    public function curlWithBody($url,$header,$method,$body_data_json){
        $curl = curl_init($this->base_url.$url);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_POSTFIELDS, $body_data_json);
        curl_setopt($curl,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function grant()
    {
        $bkash = DB::table('payment_config')->where('id', 1)->first();
        
        $header = array(
                'Content-Type:application/json',
                'username: ' . $bkash->user_name,
                'password: ' . $bkash->user_password
                );
        $header_data_json=json_encode($header);

        $body_data = array('app_key'=> $bkash->user_app_key, 'app_secret'=> $bkash->user_app_secret);
        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/token/grant',$header,'POST',$body_data_json);

        $token = json_decode($response)->id_token;

        return $token;
    }

    public function pay(Request $request)
    {
        
        $order = Order::find($request->id);
        $amount = $order->total_cost;
        $orderID = $order->tracking_no;
        
        Session::forget('payment_amount');
        Session::put('payment_amount', $amount);
        
        Session::forget('order_id');
        Session::put('order_id', $orderID);
        
        return view('CheckoutURL.pay');
    }

    public function create(Request $request)
    {     
        Session::forget('bkash_token');
        $token = $this->grant();
        Session::put('bkash_token', $token);

        $header =$this->authHeaders();
        
        $body_data = array(
            'mode' => '0011',
            'payerReference' => ' ',
            'callbackURL' => 'https://www.kinivalo.com/bkash/checkout-url/callback',
            'amount' => Session::get('payment_amount'),
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => Session::get('order_id') // you can pass here you OrderID
        );
        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/create',$header,'POST',$body_data_json);
        Session::forget('paymentID');
        Session::put('paymentID', json_decode($response)->paymentID);
        return redirect((json_decode($response)->bkashURL));
    }

    public function execute($paymentID)
    {
        $header =$this->authHeaders();
        
        $body_data = array(
            'paymentID' => $paymentID
        );
        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/execute',$header,'POST',$body_data_json);
        
        $res_array = json_decode($response,true);

        if(isset($res_array['trxID'])){
            $trxID = $res_array['trxID'];
            $paymentID = $res_array['paymentID'];
            $amount = $res_array['amount'];
            $invoiceNo = $res_array['merchantInvoiceNumber'];
            $customerMsisdn = $res_array['customerMsisdn'];
             
            Order::where('tracking_no',$invoiceNo)->update(['payment_status' => 'paid']); 
            Order::where('tracking_no',$invoiceNo)->update(['transaction_id' => $trxID]); 
        
        }

        return $response;
    }

    public function query($paymentID)
    {

        $header =$this->authHeaders();

        $body_data = array(
            'paymentID' => $paymentID,
        );
        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/payment/status',$header,'POST',$body_data_json);

        $res_array = json_decode($response,true);

        if(isset($res_array['trxID'])){
            $trxID = $res_array['trxID'];
            $paymentID = $res_array['paymentID'];
            $amount = $res_array['amount'];
            $invoiceNo = $res_array['merchantInvoiceNumber'];
            $customerMsisdn = $res_array['customerMsisdn'];
             
            // your database insert operation
        
        }

        return $response;
    }

    public function callback(Request $request)
    {
        $allRequest = $request->all();
        if(isset($allRequest['status']) && $allRequest['status'] == 'failure'){
            return view('CheckoutURL.fail')->with([
                'response' => 'Payment Failure'
            ]);
            
        }else if(isset($allRequest['status']) && $allRequest['status'] == 'cancel'){
            return view('CheckoutURL.fail')->with([
                'response' => 'Payment Cancel'
            ]);

        }else{
            
            $response = $this->execute($allRequest['paymentID']);

            $arr = json_decode($response,true);
    
            if(array_key_exists("statusCode",$arr) && $arr['statusCode'] != '0000'){
                return view('CheckoutURL.fail')->with([
                    'statusMessage' => $arr['statusMessage'],
                ]);
            }else if(array_key_exists("message",$arr)){
                // if Execute Api Failed to response
                sleep(1);
                $queryResponse = $this->query($allRequest['paymentID']);
                return view('CheckoutURL.success')->with([
                    'response' => $queryResponse
                ]);
            }
    
            return view('CheckoutURL.success')->with([
                'response' => $response
            ]);

        }

    }
 
    public function getRefund(Request $request)
    {
        return view('CheckoutURL.refund');
    }

    public function refund(Request $request)
    {
        Session::forget('bkash_token');
        $token = $this->grant();
        Session::put('bkash_token', $token);

        $header =$this->authHeaders();

        $body_data = array(
            'paymentID' => $request->paymentID,
            'amount' => $request->amount,
            'trxID' => $request->trxID,
            'sku' => 'sku',
            'reason' => 'Quality issue'
        );
     
        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/payment/refund',$header,'POST',$body_data_json);
        // your database operation
        return view('CheckoutURL.refund')->with([
            'response' => $response,
        ]);
    }

    
    public function getRefundStatus(Request $request)
    {
        return view('CheckoutURL.refund-status');
    }

    public function refundStatus(Request $request)
    {     
        Session::forget('bkash_token');  
        $token = $this->grant();
        Session::put('bkash_token', $token);

        $header =$this->authHeaders();

        $body_data = array(
            'paymentID' => $request->paymentID,
            'trxID' => $request->trxID,
        );
        $body_data_json = json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/payment/refund',$header,'POST',$body_data_json);
                
        return view('CheckoutURL.refund-status')->with([
            'response' => $response,
        ]);
    }
    
}

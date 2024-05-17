<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Order;
use DB;
class paymentController extends Controller
{
    public function payment(Request $request){
        
        $aamarpay = DB::table('payment_config')->where('id', 3)->first();
        
        $order = Order::find($request->id);
        
        $amount = $order->total_cost;
        
        $tran_id = $order->tracking_no;

        $currency= "BDT"; //aamarPay support Two type of currency USD & BDT  

        $store_id = $aamarpay->store_id; 

        $signature_key = $aamarpay->signature_key; 
        
        

        $url = "https://secure.aamarpay.com/jsonpost.php"; // for Sandbox Transection use "https://sandbox.aamarpay.com/jsonpost.php"

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "store_id": "'.$store_id.'",
            "tran_id": "'.$tran_id.'",
            "success_url": "'.route('success').'",
            "fail_url": "'.route('fail').'",
            "cancel_url": "'.route('cancel').'",
            "amount": "'.$amount.'",
            "currency": "'.$currency.'",
            "signature_key": "'.$signature_key.'",
            "desc": "Merchant Registration Payment",
            "cus_name": "'.$order->customer_name.'",
            "cus_email": "payer@merchantcusomter.com",
            "cus_add1": "'.$order->delivery_address.'",
            "cus_add2": "Mohakhali DOHS",
            "cus_city": "Dhaka",
            "cus_state": "Dhaka",
            "cus_postcode": "1206",
            "cus_country": "Bangladesh",
            "cus_phone": "'.$order->customer_phone.'",
            "type": "json"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // dd($response);
        
        $responseObj = json_decode($response);

        if(isset($responseObj->payment_url) && !empty($responseObj->payment_url)) {

            $paymentUrl = $responseObj->payment_url;
            // dd($paymentUrl);
            return redirect()->away($paymentUrl);

        }else{
            echo $response;
        }



    }

    public function success(Request $request){

        $request_id= $request->mer_txnid;
        $tran_id= $request->tran_id;

        //verify the transection using Search Transection API 

        $url = "http://secure.aamarpay.com/api/v1/trxcheck/request.php?request_id=$request_id&store_id=kinivalo&signature_key=097b3609840d6e2e669732d2b7008cbb&type=json";
        
        //For Sandbox Transection Use " http://sandbox.aamarpay.com/api/v1/trxcheck/request.php"
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        Order::where('tracking_no',$request_id)->update(['payment_status' => 'paid']); 
        Order::where('tracking_no',$request_id)->update(['transaction_id' => $tran_id]); 
            
        
        return view('aamarpay.success')->with([
            'response' => $response
        ]);

    }

    public function fail(Request $request){
        
        $requestData = $request->all(); 
        return view('aamarpay.fail')->with(['response' => $request]);
    }

    public function cancel(){
        return 'Canceled';
    }
}

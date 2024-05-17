<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Basic;
use App\Notifysetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BackBasicsController extends Controller
{
    public function edit(){
        $info = Basic::find(1);

        return view('back-end.basic',[
          'info' => $info
        ]);
    }

    public function update(Request $request){

      if(Auth::check()){

        request()->validate([
          'name' => 'required|min:3',
          'contact_no' => 'required|min:5',
          'phone' => 'required',
          'bkas' => 'required',
          'logo' => 'image',
          'f_logo' => 'image'
        ]);

        $folder = "public/image/manufacturer_logo/";

        if($logo = $request->file('logo')){
          if(file_exists($request->preLogo)){
            unlink($request->preLogo);
          }
          $ext = $logo->extension();
          $logo_name = "logo.".$ext;
          $logo_url = $folder.$logo_name;
          $logo->move($folder,$logo_name);
        } else {
          $logo_url = $request->preLogo;
        }

        if($f_logo = $request->file('f_logo')){
          if(file_exists($request->preLogo_f)){
            unlink($request->preLogo_f);
          }
          $ext = $f_logo->extension();
          $logo_name = "f_logo.".$ext;
          $logo_url_footer = $folder.$logo_name;
          $f_logo->move($folder,$logo_name);
        } else {
          $logo_url_footer = $request->preLogo_f;
        }
        
        

        $info = Basic::find(1);
        $info->name = $request->name;
        $info->contact_no = $request->contact_no;
        $info->email_address = $request->email_address;
        $info->phone = $request->phone;
        $info->bkas = $request->bkas;
        $info->logo = $logo_url;
        $info->f_logo = $logo_url_footer;
        $info->address = $request->address;
        $info->footer_details = $request->footer_details;
        $info->facebook = $request->facebook;
        $info->twitter = $request->twitter;
        $info->instagram = $request->instagram;
        $info->youtube = $request->youtube;
        $info->linkedin = $request->linkedin;
        
        $info->save();

        return back()->with('msg-success', 'Success!! Info updated successfully.');
      }
      return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
    }

    public function delivery_edit(){
        $info = Basic::find(1);

        return view('back-end.delivery',[
          'info' => $info
        ]);
    }

    public function delivery_update(Request $request){
      if(Auth::check()){
        request()->validate([
          'delivery_cost1' => 'required',
          'delivery_cost2' => 'required'
        ]);

        $info = Basic::find(1);
        $info->delivery_cost1 = $request->delivery_cost1;
        $info->delivery_cost2 = $request->delivery_cost2;
        $info->inside_details = $request->inside_details;
        $info->outside_details = $request->outside_details;

        $info->save();

        return back()->with('msg-success', 'Success!! Info updated successfully.');
      }
      return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
    }

    public function code_edit(){
        $info = Basic::find(1);

        return view('back-end.code',[
          'info' => $info
        ]);
    }

    public function code_update(Request $request){
      if(Auth::check()){
        $info = Basic::find(1);
        $info->header_code = $request->header_code;
        $info->footer_code = $request->footer_code;

        $info->save();

        return back()->with('msg-success', 'Success!! Code updated successfully.');
      }
      return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
    }
    public function mail_edit(){
        $info = Notifysetting::latest()->first();
        //dd($info);
        return view('back-end.emailsetting',[
          'info' => $info
        ]);
    }

    public function mail_update(Request $request){

      if(Auth::check()){
        request()->validate([
          'admin_mail' => 'sometimes|nullable|email'
        ]);
        $notify_customer = 0;
        $notify_admin = 0;
        if($request->has('notify_customer')){
          $notify_customer = 1;
        }
        if($request->has('notify_admin')){
          $notify_admin = 1;
        }
        $info = Notifysetting::latest()->first();

        $info->notify_customer = $notify_customer;
        $info->notify_admin = $notify_admin;
        $info->admin_mail = $request->admin_mail;
        $info->mail_driver = $request->mail_driver;
        $info->mail_host = $request->mail_host;
        $info->mail_port = $request->mail_port;
        $info->mail_username = $request->mail_username;
        $info->mail_password = $request->mail_password;
        $info->mail_encryption = $request->mail_encryption;
        $info->mail_from_address = $request->mail_from_address;
        $info->mail_from_name = $request->mail_from_name;

        $info->save();

        return back()->with('msg-success', 'Success!! Settings updated successfully.');
      }
      return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
    }

    public function notice_edit(){
        return view("back-end.notice_board");
    }

    public function notice_save(Request $request){

        if(Auth::check()){
            $notice_enabled = 0;
            if($request->has('notice_enabled')){
                $notice_enabled = 1;
            }
            $info = Basic::latest()->first();

            $info->notice_enabled = $notice_enabled;
            $info->notice_text = $request->notice_text;

            $info->save();

            Cache::forget('basic_data');
            return back()->with('msg-success', 'Success!! Notice board Settings updated successfully.');
        }
        return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
    }
    
    
    public function sms_config(){

        $api_info = DB::table('sms_config')->where('id', 1)->first();

        return view('back-end.sms_config',[
          'api_info' => $api_info
        ]);
    }
    
    
    public function sms_update(Request $request){

      if(Auth::check()){

        request()->validate([
          'api_key' => 'required',
          'api_url' => 'required'
        ]);

        DB::table('sms_config')
        ->where('id', 1)
        ->update([
            'sender_id' => $request->sender_id,
            'api_key' => $request->api_key,
            'api_url' => $request->api_url,
            'activity' => $request->activity
        ]);
   

        return back()->with('msg-success', 'Success!! SMS info updated.');
      }
      return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
    }
    
    
    public function payment_config(){

        $cod = DB::table('payment_config')->where('id', 2)->first();
        $bkash = DB::table('payment_config')->where('id', 1)->first();
        $aamarpay = DB::table('payment_config')->where('id', 3)->first();
       
        return view('back-end.payment_config',[
          'bkash' => $bkash,
          'cod' => $cod,
          'aamarpay' => $aamarpay,
        ]);
    }
    
    
    
    public function payment_update(Request $request){

      if($request->payment_method == 'bkash'){
        
        request()->validate([
          'user_name' => 'required',
          'user_password' => 'required',
          'user_app_key' => 'required',
          'user_app_secret' => 'required'
        ]);

        DB::table('payment_config')
        ->where('id', 1)
        ->update([
            'user_name' => $request->user_name,
            'user_password' => $request->user_password,
            'user_app_key' => $request->user_app_key,
            'user_app_secret' => $request->user_app_secret,
            'activity' => $request->activity
        ]);

        return back()->with('msg-success', 'Success!! Payment info updated.');
      }
      


      
      
      if($request->payment_method == 'aamarpay'){
        
        request()->validate([
          'store_id' => 'required',
          'signature_key' => 'required'
        ]);

        DB::table('payment_config')
        ->where('id', 3)
        ->update([
            'store_id' => $request->store_id,
            'signature_key' => $request->signature_key,
            'activity' => $request->activity
        ]);

        return back()->with('msg-success', 'Success!! Payment info updated.');
      }
      
      
      
      if($request->payment_method == 'cod'){
          
           DB::table('payment_config')
            ->where('id', 2)
            ->update([
                'activity' => $request->activity,
            ]);
            
        return back()->with('msg-success', 'Success!! Payment info updated.');
        
      }
      
      
      
      return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
      
      
      
    }
    
    
    
    
    
}

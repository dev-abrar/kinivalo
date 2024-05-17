<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;

class AjaxController extends Controller
{
    public function change_product_sts($id){
        if(Auth::check()){
            $product = Product::find($id);
            $status = "Publish";
            $sts = 1;
            if($product->sts == 1){
                $status = "Deactive";
                $sts = 2;
            }

            if($product){
                $product->status = $status;
                $product->sts = $sts;
                $product->save();

                return redirect()->back();
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }
}
            

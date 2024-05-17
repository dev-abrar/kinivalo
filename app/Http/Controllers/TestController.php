<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TestController extends Controller
{
    public function test(){
        $records = DB::select('SELECT products.id as id, products.pcode as pcode, products.title as title, products.rprice as rprice, products.sprice as sprice, products.qty as qty, 
                                    products.img1 as img1,products.pdate as pdate,
                                    (SELECT sum(order_details.product_qty) FROM order_details WHERE product_id = products.id) as sold_qty FROM products');
        dd($records);
    }
}

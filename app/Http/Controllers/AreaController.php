<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use App\Customer;
use App\Models\User;
use App\Order;
use App\PrescriptionUpload;
use App\WebsiteReview;
use App\Division;
use Response;
use DB;


class AreaController extends Controller {
    /* Dependent Table Start  */
    public function getDistrictsByDivision(Request $request){
        $data=$request->all();
        $districts=DB::table('districts')
        ->where('districts.division_id','=',$data['division'])
        ->select('id','name')
        ->get();
        return Response::json($districts);
    }

    public function getThanaByDistrict(Request $request){
        $data=$request->all();
        $thana=DB::table('upazilas')
        ->where('upazilas.district_id','=',$data['districts'])
        ->select('id','name')
        ->get();
        return Response::json($thana);
    }
    /* Dependent Table End  */

}

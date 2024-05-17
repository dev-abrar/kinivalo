<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CkEditorController extends Controller
{
    public function uploadCKeditorFile(Request $request){
        $upload = '';
        $name = '';
    
        if ($request->file('upload')) {
            $image = $request->file('upload');
            $name = $image->getClientOriginalName().'.'.$image->getClientOriginalExtension();
            $upload = uploadPlease($request->file('upload'));
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $msg = "Photo Uploaded Successfully!";
            $url =  asset($upload);
        }
    
        $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
        echo $response;

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\SeoPage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SeoPageController extends Controller
{

    public function seoPagesIndex(){
        $data['pages'] = SeoPage::latest()->orderBy('slug', 'asc')->paginate(10);
        return view('back-end.seo.indexSeoContent',$data);
    }

    public function addSeoPageContent(){
        return view('back-end.seo.addSeoContent');
    }

    public function storeSeoPageContent(Request $request){
             
            $image = "";
            if ($request->file('image')) {
                $image = uploadPlease($request->file('image'));
            }
            
            $seo = new SeoPage();
            $seo->slug = $request->slug;
            $seo->author = $request->author;
            $seo->description = $request->description;
            $seo->title = $request->title;
            $seo->keywords = $request->keywords;
            $seo->published_time = Carbon::parse($request->published_time);
            $seo->modified_time = Carbon::parse($request->modified_time);
            $seo->expiration_time = Carbon::parse($request->expiration_time);
            $seo->section = $request->section;
            $seo->canonical = $request->canonical;
            $seo->og_locale = $request->og_locale;
            $seo->og_url = $request->og_url;
            $seo->og_type = $request->og_type;
            $seo->image_url = $request->image_url;
            $seo->image_height = $request->image_height;
            $seo->link_img_size = $request->link_img_size;
            $seo->image_width = $request->image_width;
            $seo->twitter_side = $request->twitter_side;
            $seo->type = $request->type;
            $seo->image = $image;
            $seo->created_by = Auth::id();
            $seo->save();
       

        

        if ($seo == true) {
            $notification = ([
                'success' => 'SEO Content Updated Successfully',
            ]);
        } else {
            $notification = ([
                'error' => 'Opps! Something is wrong...!',
            ]);
        }
        return redirect('/pages-list')->with($notification);
    }

    public function pageContentUpdate($seo_id) {
        $data['page'] = SeoPage::findOrFail($seo_id);
        return view('back-end.seo.updateSeoContent', $data);
    }

    public function updateSeoPageContent(Request $request){
        
        $seo = SeoPage::findOrFail($request->id);
        
        $image = $seo->image;
        if ($request->file('image')) {
            File::delete($seo->image);
            $image = uploadPlease($request->file('image'));
        }
    
        $seo->slug = $request->slug;
        $seo->author = $request->author;
        $seo->description = $request->description;
        $seo->title = $request->title;
        $seo->keywords = $request->keywords;
        $seo->published_time = Carbon::parse($request->published_time);
        $seo->modified_time = Carbon::parse($request->modified_time);
        $seo->expiration_time = Carbon::parse($request->expiration_time);
        $seo->section = $request->section;
        $seo->canonical = $request->canonical;
        $seo->og_locale = $request->og_locale;
        $seo->og_url = $request->og_url;
        $seo->og_type = $request->og_type;
        $seo->image_url = $request->image_url;
        $seo->image_height = $request->image_height;
        $seo->image_width = $request->image_width;
        $seo->twitter_side = $request->twitter_side;
        $seo->link_img_size = $request->link_img_size;
        $seo->image = $image;
        $seo->created_by = Auth::id();
        $seo->save();
   

        

        if ($seo == true) {
            $notification = ([
                'success' => 'SEO Content Updated Successfully',
            ]);
        } else {
            $notification = ([
                'error' => 'Opps! Something is wrong...!',
            ]);
        }
        return redirect('/pages-list')->with($notification);
    }

    public function deletePage($page_id)
    {
        SeoPage::findOrFail($page_id)->delete();
        return redirect()->back();
    }

}

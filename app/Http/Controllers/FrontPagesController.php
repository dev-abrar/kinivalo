<?php

namespace App\Http\Controllers;

use App\Models\SeoPage;
use Illuminate\Http\Request;
use App\Page;

class FrontPagesController extends Controller
{
    public function index($slug){
      $page = Page::where('slug',$slug)->first();

      $seo = SeoPage::where('slug', $slug)->first();
      if ($seo) {
          perform_seo($seo);
      }
      return view('front-end.page',[
        'page' => $page
      ]);
    }
}

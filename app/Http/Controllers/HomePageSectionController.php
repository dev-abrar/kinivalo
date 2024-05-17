<?php

namespace App\Http\Controllers;

use App\Category;
use App\HomePageSection;
use Illuminate\Http\Request;
use Auth;

class HomePageSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $options = HomePageSection::latest()->first();

        return view('back-end.home_page_setup', [
            'categories' => $categories,
            'options' => $options
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check()){
            $options = HomePageSection::latest()->first();
            $options->hotdeals = $request->has('hotdeal') ? 1 : 0;
            $options->section_name_1 = $request->section_name_1;
            $options->section_1 = $request->has('section_1') ? 1 : 0;
            $options->section_name_2 = $request->section_name_2;
            $options->section_ctg_2 = $request->section_ctg_2;
            $options->section_2 = $request->has('section_2') ? 1 : 0;
            $options->section_name_3 = $request->section_name_3;
            $options->section_ctg_3 = $request->section_ctg_3;
            $options->section_3 = $request->has('section_3') ? 1 : 0;
            $options->section_name_4 = $request->section_name_4;
            $options->section_ctg_4 = $request->section_ctg_4;
            $options->section_4 = $request->has('section_4') ? 1 : 0;
            $options->save();
            return back()->with('msg-success', 'Success!! Settings updated successfully.');
        }
        return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HomePageSection  $homePageSection
     * @return \Illuminate\Http\Response
     */
    public function show(HomePageSection $homePageSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HomePageSection  $homePageSection
     * @return \Illuminate\Http\Response
     */
    public function edit(HomePageSection $homePageSection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HomePageSection  $homePageSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomePageSection $homePageSection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HomePageSection  $homePageSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomePageSection $homePageSection)
    {
        //
    }
}

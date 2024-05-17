<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Auth;

class BackCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::whereNull('mctg')->get();
        //dd($categories);

        return view('back-end.categories', [
          'categories' => $categories
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
        //dd($request->all());
        $last_position = Category::where('sts',1)->orderBy('position','DESC')->first();
        if($last_position){
          $new_position = $last_position->position + 1;
        } else {
          $new_position = 1;
        }
        if($request->has('sts')){
          $sts = 1;
        } else {
          $sts = 0;
          $new_position = null;
        }

        if(Auth::check()){
          request()->validate([
            'name' => 'required|min:3',
            'slug' => 'required|min:3',
          ]);
          
          
        $category = new Category();
          
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $file_extension = $file->getClientOriginalExtension();
            $random_string = rand(1,12);
            $file_name = $random_string.'.'.$file_extension;
            $destination_path = 'image/banner/';
            $request->file('photo')->move($destination_path, $file_name);
            $category->photo = $file_name;
         }
          
          $category->name = $request->name;
          $category->slug = $request->slug;
          $category->position = $new_position;
          $category->sts = $sts;
          $category->save();

          return back()->with('msg-success', 'Success!! New category added successfully.');

        }
        return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
    }
    
    public function addsub(Request $request)
    {
        //dd($request->all());
        if($request->has('substs')){
          $sts = 1;
        } else {
          $sts = 0;
        }

        if(Auth::check()){
          request()->validate([
            'subname' => 'required|min:3',
            'subslug' => 'required|min:3',
            'mctg' => 'required'
          ]);

          //dd($request->mctg);

          $category = new Category();

          $category->name = $request->subname;
          $category->slug = $request->subslug;
          $category->mctg = $request->mctg;
          $category->sts = $sts;

          $category->save();

          return back()->with('msg-success', 'Success!! New sub-category added successfully.');

        }
        return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      if(Auth::check()){
        request()->validate([
          'edit_name' => 'required|min:3',
          'edit_slug' => 'required|min:3'
        ]);
        //dd($request->all());
        $new_position = $request->edit_pos; //4

        if($new_position == ""){
          $category = Category::whereNull('mctg')->orderBy('position','DESC')->first();
          $position = $category->position+1;
        }

        if($request->has('edit_sts')){
          $sts = 1;
          $position = $new_position;
        } else {
          $sts = 0;
          $position = null;
        }
        
       
        $category = Category::find($request->edit_id);
     
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $file_extension = $file->getClientOriginalExtension();
            $random_string = rand(1,12);
            $file_name = $random_string.'.'.$file_extension;
            $destination_path = 'image/banner/';
            $request->file('photo')->move($destination_path, $file_name);
            $category->photo = $file_name;
        }

        $category->name = $request->edit_name;
        $category->slug = $request->edit_slug;
        $category->position = $position;
        $category->sts = $sts;
        $category->save();
        return back()->with('msg-success', 'Success!! Category info updated successfully.');
      }
      return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
    }

    public function updatesub(Request $request)
    {
      if(Auth::check()){
        request()->validate([
          'edit_sub_name' => 'required|min:3',
          'edit_sub_slug' => 'required|min:3',
          'edit_mctg' => 'required'
        ]);

        if($request->has('edit_sub_sts')){
          $sts = 1;
        } else {
          $sts = 0;
        }

        $category = Category::find($request->edit_sub_id);

        $category->name = $request->edit_sub_name;
        $category->slug = $request->edit_sub_slug;
        $category->mctg = $request->edit_mctg;
        $category->sts = $sts;

        $category->save();
        return back()->with('msg-success', 'Success!! Sub-Category info updated successfully.');
      }
      return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        $pre = Category::find($request->delete_id);
        
        $pre->delete();

        return back()->with('msg-success', 'Success!! Deleted successfully.');
    
    }
}

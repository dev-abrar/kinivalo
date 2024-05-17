<?php

namespace App\Http\Controllers;

use App\Variation;
use App\VariationsOption;
use Illuminate\Http\Request;
use Auth;

class VariationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $variations = Variation::all();
        return view('back-end.variations', [
           'variations' => $variations
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

            request()->validate([
                'name' => 'required|min:2'
            ]);

            $variation = new Variation();
            $variation->name = $request->name;

            $variation->save();

            return back()->with('msg-success', 'Success!! New variation added successfully.');
        }
        return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
    }

    public function save_option(Request $request)
    {
        if(Auth::check()){

            request()->validate([
                'variation_id' => 'required',
                'option' => 'required|min:2'
            ]);

            $option = new VariationsOption();
            $option->variation_id = $request->variation_id;
            $option->option = $request->option;

            $option->save();

            return back()->with('msg-success', 'Success!! New option added successfully.');
        }
        return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
    }
    public function update_option(Request $request)
    {
        if(Auth::check()){

            request()->validate([
                'edit_opt_id' => 'required',
                'edit_opt_name' => 'required',
                'edit_var' => 'required',
            ]);

            $option = VariationsOption::find($request->edit_opt_id);
            $option->variation_id = $request->edit_var;
            $option->option = $request->edit_opt_name;

            $option->save();

            return back()->with('msg-success', 'Success!! Option updated successfully.');
        }
        return back()->with('msg-error', 'Opps!! Something wrong, please try again.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Variation  $variation
     * @return \Illuminate\Http\Response
     */
    public function show(Variation $variation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Variation  $variation
     * @return \Illuminate\Http\Response
     */
    public function edit(Variation $variation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Variation  $variation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Variation $variation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Variation  $variation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variation $variation)
    {
        //
    }
}

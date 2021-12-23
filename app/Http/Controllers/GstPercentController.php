<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GstPercent;
use DB;
use Auth;
use Validator;
use Image;

class GstPercentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gst = GstPercent::all();
        return view('gst_percent.index',compact('gst'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gst_percent.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();
            $this->validate($request,[
                'name' =>'required',
                'percent'=>'required|numeric'
            ],[
                'name.required'=>'This is required',
                'percent.required' => 'This is required',
                'percent.numeric' => 'This field only take numeric value'
            ]);
            DB::beginTransaction();
            $gst = new GstPercent();
            $input['created_by'] = Auth::id();
            $gst->create($input);

        } catch (\Illuminate\Database\QueryException $th) {
            DB::rollback();
            return back()->with('error','Something went wrong '.$th->getMessage());
        }
        DB::commit();
        return back()->with('success','GST is created successfully');
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
        $gst = GstPercent::findOrFail($id);
        return view('gst_percent.edit',compact('gst'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $input = $request->all();
            $this->validate($request,[
                'name' =>'required',
                'percent'=>'required|numeric'
            ],[
                'name.required'=>'This is required',
                'percent.required' => 'This is required',
                'percent.numeric' => 'This field only take numeric value'
            ]);
            DB::beginTransaction();
            $gst = GstPercent::findOrFail($id);
            $input['updated_by'] = Auth::id();
            $gst->update($input);

        } catch (\Illuminate\Database\QueryException $th) {
            DB::rollback();
            return back()->with('error','Something went wrong '.$th->getMessage());
        }
        DB::commit();
        return back()->with('success','GST is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gst = GstPercent::find($id);

        $value = $gst->delete();
        if ($value) {
            return back()->with('success','GST is deleted successfully.');
        }
    }
}

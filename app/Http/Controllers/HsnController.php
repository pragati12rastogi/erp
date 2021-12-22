<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hsn;
use DB;
use Auth;
use Validator;
use Image;

class HsnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hsn = Hsn::all();
        return view('hsn.index',compact('hsn'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hsn.create');
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
                'hsn_no' =>'required'
            ],[
                'hsn_no.required'=>'This is required'
            ]);
            DB::beginTransaction();
            $hsn = new Hsn();
            $hsn->create($input);

        } catch (\Illuminate\Database\QueryException $th) {
            DB::rollback();
            return back()->with('error','Something went wrong '.$th->getMessage());
        }
        DB::commit();
        return back()->with('success','Hsn is created successfully');

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
        $hsn = Hsn::findOrFail($id);
        return view('hsn.edit',compact('hsn'));
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
                'hsn_no' =>'required'
            ],[
                'hsn_no.required'=>'This is required'
            ]);
            DB::beginTransaction();
            $hsn = Hsn::findOrFail($id);
            $hsn->update($input);

        } catch (\Illuminate\Database\QueryException $th) {
            DB::rollback();
            return back()->with('error','Something went wrong '.$th->getMessage());
        }
        DB::commit();
        return back()->with('success','Hsn is updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hsn = Hsn::find($id);

        $value = $hsn->delete();
        if ($value) {
            return back()->with('success','Hsn is deleted successfully.');
        }
    }
}

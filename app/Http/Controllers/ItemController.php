<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Item;
use App\Models\GstPercent;
use App\Models\Category;
use App\Models\Hsn;
use Image;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        return view('item.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $gsts = GstPercent::all();
        $hsns = Hsn::all();
        return view('item.create',compact('categories','gsts','hsns'));
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
                'name' => 'required',
                'category_id' => 'required',
                'photo' => 'required|mimes:jpeg,jpg,png',
                'hsn_id' => 'required',
                'gst_percent_id' => 'required'
            ],[
                'name.required'=>'This is required',
                'category_id.required'=>'This is required',
                'photo.required'=>'This is required',
                'photo.mimes'=>'Accept only jpeg,png,jpg extensions',
                'hsn_id.required'=>'This is required',
                'gst_percent_id.required'=>'This is required'
            ]);

            DB::beginTransaction();
            $item = new Item();
            if ($file = $request->file('photo')) {
                
                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/uploads/items/';
                $image = time() .'.'. $file->getClientOriginalExtension();
                
                $optimizeImage->save($optimizePath . $image, 90);
    
                $input['image'] = $image;
    
            }
            $item->create($input);

        } catch (\Illuminate\Database\QueryException $th) {
            DB::rollback();
            return back()->with('error','Something went wrong '.$th->getMessage());
        }
        DB::commit();
        return back()->with('success','Item is created successfully');
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
        $categories = Category::all();
        $gsts = GstPercent::all();
        $hsns = Hsn::all();
        $item = Item::findOrFail($id);
        return view('item.edit',compact('categories','gsts','hsns','item'));
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
                'name' => 'required',
                'category_id' => 'required',
                'photo' => 'mimes:jpeg,jpg,png',
                'hsn_id' => 'required',
                'gst_percent_id' => 'required'
            ],[
                'name.required'=>'This is required',
                'category_id.required'=>'This is required',
                
                'photo.mimes'=>'Accept only jpeg,png,jpg extensions',
                'hsn_id.required'=>'This is required',
                'gst_percent_id.required'=>'This is required'
            ]);

            DB::beginTransaction();
            $item = Item::findOrFail($id);
            if ($file = $request->file('photo')) {
                
                if ($item->image != '' && file_exists(public_path() . '/uploads/items/' . $item->image)) {
                    unlink(public_path() . '/uploads/items/' . $item->image);
                }

                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/uploads/items/';
                $image = time() .'.'. $file->getClientOriginalExtension();
                
                $optimizeImage->save($optimizePath . $image, 90);
    
                $input['image'] = $image;
    
            }
            $item->update($input);

        } catch (\Illuminate\Database\QueryException $th) {
            DB::rollback();
            return back()->with('error','Something went wrong '.$th->getMessage());
        }
        DB::commit();
        return back()->with('success','Item is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        $value = $item->delete();
        if ($value) {
            return back()->with('success','Item is deleted successfully.');
        }
    }
}
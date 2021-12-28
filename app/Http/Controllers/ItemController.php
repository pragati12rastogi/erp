<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Item;
use App\Models\ItemPhoto;
use App\Models\GstPercent;
use App\Models\Category;
use App\Models\Hsn;
use Image;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::orderBy('id','Desc')->get();
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
                'photo.*' => 'required|mimes:jpeg,jpg,png',
                'hsn_id' => 'required',
                'gst_percent_id' => 'required'
            ],[
                'name.required'=>'This is required',
                'category_id.required'=>'This is required',
                'photo.*.required'=>'This is required',
                'photo.*.mimes'=>'Accept only jpeg,png,jpg extensions',
                'hsn_id.required'=>'This is required',
                'gst_percent_id.required'=>'This is required'
            ]);
            
            DB::beginTransaction();
            $item = new Item();
            
            $input['created_by'] = Auth::id();
            $getid = $item->create($input);
            
            foreach ($input['photo'] as $f => $file ) {
                
                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/uploads/items/';
                $image = Str::random(5).time() .'.'. $file->getClientOriginalExtension();
                
                $optimizeImage->save($optimizePath . $image, 90);
    
                ItemPhoto::insert([
                    'item_id'=>$getid->id,
                    'photo' => $image
                ]);
                
            }

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
                'photo.*' => 'mimes:jpeg,jpg,png',
                'hsn_id' => 'required',
                'gst_percent_id' => 'required'
            ],[
                'name.required'=>'This is required',
                'category_id.required'=>'This is required',
                
                'photo.*.mimes'=>'Accept only jpeg,png,jpg extensions',
                'hsn_id.required'=>'This is required',
                'gst_percent_id.required'=>'This is required'
            ]);

            DB::beginTransaction();
            $item = Item::findOrFail($id);
            
            if(!isset($input['photo']) && count($item->images)<= 0){
                return back()->with('error','Item image is required please select any product image');
            }

            foreach ($input['photo'] as $f => $file ) {
                
                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/uploads/items/';
                $image = Str::random(5).time() .'.'. $file->getClientOriginalExtension();
                
                $optimizeImage->save($optimizePath . $image, 90);
    
                ItemPhoto::insert([
                    'item_id' => $id,
                    'photo' => $image
                ]);
                
            }

            $input['updated_by'] = Auth::id();
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
        if(count($item->images)>0){
            foreach($item->images as $i => $photo){
                if ($photo->photo != '' && file_exists(public_path() . '/uploads/items/' . $photo->photo)) {
                    unlink(public_path() . '/uploads/items/' . $photo->photo);
                }
            }
        }
        ItemPhoto::where('item_id',$id)->delete();
        $value = $item->delete();

        if ($value) {
            return back()->with('success','Item is deleted successfully.');
        }
    }

    public function delete_item_photo($id){
        $photo = ItemPhoto::find($id);

        if ($photo->photo != '' && file_exists(public_path() . '/uploads/items/' . $photo->photo)) {
            unlink(public_path() . '/uploads/items/' . $photo->photo);
        }
        
        $photo->delete();
        return back()->with('success','Image deleted successfully');
    }
}

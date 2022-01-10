<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\StockHistory;
use App\Models\Category;
use App\Models\Hsn;
use App\Models\Item;
use App\Models\GstPercent;
use App\Models\Vendor;
use Validator;
use DB;
use Image;
use Auth;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::orderBy('id','Desc')->get();
        $category = Category::all();
        $hsn = Hsn::all();
        $item = Item::all();
        $gsts = GstPercent::all();
        $vendor = Vendor::all();
        return view('stocks.index',compact('stocks','category','hsn','item','gsts','vendor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        $hsn = Hsn::all();
        $item = Item::all();
        $gsts = GstPercent::all();
        $vendor = Vendor::all();
        return view('stocks.create',compact('category','hsn','item','gsts','vendor'));
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
                
            $validation = Validator::make($input,[
                'item_id'          => ['required'],
                'prod_quantity'    => ['required', 'numeric'],
                'prod_price'       => ['required', 'numeric'],
                'total_price'      => ['required','numeric'],
                'per_freight_price'=> ['required'],
                'user_percent'     => ['required'],
                'final_price'      => ['required'],
                'price_for_user'   => ['required'],
                'date_of_purchase' => ['required'],
                'vendor_id'        => ['required'],
                

            ],[
                'item_id.required'          => 'Item field is required',
                'prod_quantity.required'    => 'Product Quantity field is required',
                'prod_quantity.numeric'     => 'Product Quantity field can only accept number',
                'prod_price.required'       => 'Product Price field is required',
                'prod_price.numeric'         => 'Product Price field can only accept number',
                'total_price.required'            => 'Total Price field is required',
                'total_price.numeric'               => 'Total Price field can only accept number',
                'per_freight_price.required'         => 'Fright Price field is required',
                'user_percent.required'         => 'User Percent field is required',
                'final_price.required'         => 'Final Price field is required',
                'price_for_user.required'         => 'Price for User field is required',
                'date_of_purchase.required'         => 'Date Of Purchase field is required',
                'vendor_id.required'            => 'Vendor field is required',
            ]);

            if($validation->fails()){
                $validation_arr = $validation->errors();
                $message = '';
                foreach ($validation_arr->all() as $key => $value) {
                    $message .= $value.', ';
                    
                }
                
                return back()->with('error',$message);

            }

                DB::beginTransaction();
                $stock = Stock::where('item_id',$input['item_id'])->first();
                
                $item = Item::findOrFail($input['item_id']);
                $gst = $item->gst_percent->percent;

                $history = $input;

                if(empty($stock)){
                    $stock = new Stock();
                    
                    $new_calculated_stock = $input['prod_quantity'];
                    $input['created_by'] = Auth::id();
                    $stock = $stock->create($input);
                }else{
                
                    $old_stock = $stock->prod_quantity;
                    $new_stock = $input['prod_quantity'];

                    $new_calculated_stock = $old_stock+$new_stock;
                    $input['prod_quantity'] = $new_calculated_stock;

                    $gst_calc = ($input['prod_price'] * $gst)/100;
                    $new_total = $new_calculated_stock * ( $input['prod_price'] + $gst_calc );
                    $input['total_price'] = $new_total ;

                    $new_freight_final_total = ($input['per_freight_price']*$new_calculated_stock)+$new_total;

                    $input['final_price'] = $new_freight_final_total;
            
                    $input['updated_by'] = Auth::id();
                    $stock->update($input);
                }

                /* ----------------------------------Stock History Creation--------------------------------------- */
                
                $history['stock_id'] =  $stock->id;
                $history['total_qty'] =  $new_calculated_stock;
                $history['gst'] =  $gst;
                $history['created_by'] = Auth::id();
                $stock_history_insertion = StockHistory::create($history);

        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return back()->with('error','some error occurred'.$ex->getMessage());
        }
        
        DB::commit();
        return back()->with('success','Stock is created successfully');
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
        $stock = Stock::where('id',$id)->with('item','vendor','item.gst_percent','item.images')->first();
        $image = '';
        if(count($stock->item->images)>0){
            $image = asset('/uploads/items/'.$stock->item->images[0]['photo']);
        }
        
        echo json_encode(compact('stock','image'));
        
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
                
            $validation = Validator::make($input,[
                
                'prod_quantity'    => ['required', 'numeric'],
                'prod_price'       => ['required', 'numeric'],
                'total_price'      => ['required','numeric'],
                'per_freight_price'=> ['required'],
                'user_percent'     => ['required'],
                'final_price'      => ['required'],
                'price_for_user'   => ['required'],
                'date_of_purchase' => ['required'],
                'vendor_id'        => ['required'],
                

            ],[
                'item_id.required'          => 'Item field is required',
                'prod_quantity.required'    => 'Product Quantity field is required',
                'prod_quantity.numeric'     => 'Product Quantity field can only accept number',
                'prod_price.required'       => 'Product Price field is required',
                'prod_price.numeric'         => 'Product Price field can only accept number',
                'total_price.required'            => 'Total Price field is required',
                'total_price.numeric'               => 'Total Price field can only accept number',
                'per_freight_price.required'         => 'Fright Price field is required',
                'user_percent.required'         => 'User Percent field is required',
                'final_price.required'         => 'Final Price field is required',
                'price_for_user.required'         => 'Price for User field is required',
                'date_of_purchase.required'         => 'Date Of Purchase field is required',
                'vendor_id.required'            => 'Vendor field is required',
            ]);

            if($validation->fails()){
                $validation_arr = $validation->errors();
                $message = '';
                foreach ($validation_arr->all() as $key => $value) {
                    $message .= $value.', ';
                    
                }
                
                return back()->with('error',$message);
            }

            DB::beginTransaction();
            $stock = Stock::findOrFail($id);

            $history = $input;
            
            $item = Item::findOrFail($stock->item_id);
            $gst = $item->gst_percent->percent;


            $old_stock = $stock->prod_quantity;
            $new_stock = $input['prod_quantity'];

            $new_calculated_stock = $old_stock+$new_stock;
            $input['prod_quantity'] = $new_calculated_stock;

            $gst_calc = ($input['prod_price'] * $stock->item->gst_percent->percent)/100;
            $new_total = $new_calculated_stock * ( $input['prod_price'] + $gst_calc );
            $input['total_price'] = $new_total ;

            $new_freight_final_total = ($input['per_freight_price']*$new_calculated_stock)+$new_total;

            $input['final_price'] = $new_freight_final_total;
            
            $input['updated_by'] = Auth::id();
            
            $stock->update($input);
            
            /* ---------------------------------------Stock History Creation--------------------------------------- */

            
            $history['stock_id'] =  $stock->id;
            $history['total_qty'] =  $new_calculated_stock;
            $history['gst'] =  $stock->item->gst_percent->percent;
            $history['created_by'] =  Auth::id();
            
            $stock_history_insertion = StockHistory::create($history);

        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return back()->with('error','some error occurred'.$ex->getMessage());
        }
        
        DB::commit();
        return back()->with('success','Stock is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);

        $stock->delete();

        return back()->with('success','Stock deleted successfully');
    }

    public function get_items_by_category(Request $request){
        $cat_id = $request->cat_id;
        if(!empty($cat_id)){
            $items = Item::where('category_id',$cat_id)->get()->toArray();

            echo json_encode(['status'=>'success','data'=>$items]);
        }else{
            echo json_encode(['status'=>'error']);
        }
    }


    public function get_items_details(Request $request){
        $item_id = $request->item_id;
        if(!empty($item_id)){
            $items = Item::where('id',$item_id)->first();
            $items['item_image'] = '';
            if(count($items->images)>0){
                if($items->images[0]['photo'] != '' && file_exists(public_path().'/uploads/items/'.$items->images[0]['photo']) ){
                    $items['item_image'] = asset('/uploads/items/'.$items->images[0]['photo']);
                }
            }
            $items['gst_percent'] = GstPercent::where('id',$items->gst_percent_id)->first()['percent'];
            echo json_encode(['status'=>'success','data'=>$items]);
        }else{
            echo json_encode(['status'=>'error']);
        }
    }

    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distribution;
use App\Models\Item;
use App\Models\Role;
use App\Models\User;
use App\Custom\Constants;
use App\Models\Stock;
use App\Models\DistributionOrder;
use App\Models\UserStock;
use DB;
use Auth;
use Validator;

class DistributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(is_admin(Auth::user()->role_id)){
            $distribution = DistributionOrder::get();
        }else{
            $distribution = DistributionOrder::where('user_id',Auth::id())->get();
        }
       
        return view('distributer.index',compact('distribution'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Item::whereHas('stock')->get();
        $roles = Role::where('name','<>',Constants::ROLE_ADMIN)->get();
        $user = User::all();
        return view('distributer.create',compact('user','roles','items'));
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
            
            $validate = Validator::make($input ,[
                'role_id' => 'required',
                'user_id' => 'required',
                'item.*' => 'required',
                
            ],[
                'role_id.required' => 'Role is required',
                'user_id.required' => 'Please select User',
                'item.*.required' => 'No product selected',
            ]);

            if($validate->fails()){
                $validation_arr = $validate->errors();
                $message = '';
                foreach ($validation_arr->all() as $key => $value) {
                    $message = $message.' '.$value;
                }
                return back()->with('error',$message);
            }
            DB::beginTransaction();
            

            $billing_user = User::where('id',$input['user_id'])->first();
            $timestamp = date('Y-m-d H:i:s');

            $seller_user = Auth::user()->state_id;
            
            $invoice =[];
            $total_tax = 0;
            $total_cost = 0;
            foreach($input['item'] as $item_id => $qty){
                $stock = Stock::with('item.gst_percent')->where('item_id',$item_id)->first();
                $price_qty = $stock['price_for_user'] * $qty;
                
                $invoice[$item_id]['product_price'] = $stock['price_for_user'];
                $invoice[$item_id]['distributed_quantity'] = $qty;

                $tax = ($price_qty * $stock->item->gst_percent->percent)/100;
                $invoice[$item_id]['tax'] = $tax;

                $total_tax += round($tax,2);
                $total_cost += round($price_qty,2);

                if($billing_user['state_id'] == $seller_user){
                    // scgst
                    $invoice[$item_id]['scgst'] = round($tax/2,2);
                }else{
                    // igst
                    $invoice[$item_id]['igst'] = round($tax,2);
                }
                $invoice[$item_id]['product_total_price'] = $price_qty;
                $stock->decrement('prod_quantity',$qty);
            }
            
            $order = new DistributionOrder();
            $order->invoice_no = generate_invoice_no();
            $order->role_id    = $input['role_id'];
            $order->user_id    = $input['user_id'];
            $order->total_cost = $total_cost;
            $order->total_tax  = $total_tax;
            $order->created_by = Auth::id();
            $order->created_at = $timestamp;
            $order->save();
            // order created

            foreach($invoice as $item_id => $item_data){
                $invoice_insert = new Distribution();
                $invoice_insert->order_id             = $order->id;
                $invoice_insert->item_id              = $item_id;
                $invoice_insert->product_price        = $item_data['product_price'];
                $invoice_insert->user_id              = $input['user_id'];
                $invoice_insert->distributed_quantity = $item_data['distributed_quantity'];

                if(isset($item_data['scgst'])){
                    $invoice_insert->scgst            = $item_data['scgst'];
                }else if(isset($item_data['igst'])){
                    $invoice_insert->igst             =  $item_data['igst'];
                }
                $invoice_insert->product_total_price  = $item_data['product_total_price'];
                $invoice_insert->created_at = $timestamp;
                $invoice_insert->save();

                $user_stock = UserStock::updateOrCreate(
                    [
                        'user_id'=>$input['user_id'],'item_id'=>$item_id
                    ],
                    [
                        'prod_quantity'=>$item_data['distributed_quantity'],
                        'price'=>$item_data['product_price']
                    ]
                );
                
            }

        } catch (\Illuminate\Database\QueryException $th) {
            DB::rollback();
            return back()->with('error','Something went wrong: '.$th->getMessage());
        }

        DB::commit();
        return back()->with('success','Distribution done');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $dis = DistributionOrder::findOrFail($id);
        $inv_no = getInvoiceNo($id);
        return view('distributer.show',compact('dis','inv_no'));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dis = Distribution::findOrFail($id);
        $user_stock = UserStock::where('user_id',$dis['user_id'])->where('item_id',$dis['item_id'])->first();

        if($user_stock['prod_quantity'] < $dis['distributed_quantity']){
            return back()->with('error','User Sold some stock, qunatity of product is not available to cancel the product');
        }

        $user_stock->decrement('prod_quantity',$dis['distributed_quantity']);

        $stock = Stock::where('item_id',$dis['item_id'])->first();
        $stock->increment('prod_quantity',$dis['distributed_quantity']);

        
        $dis->update([
            'is_cancelled'=>1,
            'updated_by'=> Auth::id()
        ]);

        return back()->with('success','Stock Distribution Cancelled');

    }

    public function get_user(Request $request){
        $input = $request->all();

        $user = User::where('role_id',$input['role_id'])->get()->toArray();

        echo json_encode(['status'=>'success','data'=>$user]);
    }

    public function get_stock_item_detail(Request $request){
        $stock = Stock::where('item_id',$request->item_id)->first();
        echo json_encode(['status'=>'success','data'=>$stock]);
    }

    public function print_invoice($id){
        
        $dis = DistributionOrder::findOrFail($id);
        $inv_no = getInvoiceNo($id);
        return view('distributer.invoice',compact('dis','inv_no'));
    }


    public function print_single_invoice($id){
        
        $dis = Distribution::findOrFail($id);
        $inv_no = getInvoiceNo($dis->order_id);
        return view('distributer.singleinvoice',compact('dis','inv_no'));
    }
}

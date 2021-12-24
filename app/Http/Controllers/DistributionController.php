<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distribution;
use App\Models\Item;
use App\Models\Role;
use App\Models\User;
use App\Custom\Constants;
use App\Models\Stock;
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
        $distribution = Distribution::whereHas('item.stock')->get();
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
            $this->validate($request,[
                'role_id' => 'required',
                'user_id' => 'required',
                'item_id' => 'required',
                'distributed_quantity' => 'required',
                
            ],[
                'role_id.required' => 'This is required',
                'user_id.required' => 'This is required',
                'item_id.required' => 'This is required',
                'distributed_quantity.required' => 'This is required'

            ]);
            DB::beginTransaction();
            $input = $request->all();

            $billing_user = User::where('id',$input['user_id'])->first();
            $seller_user = Auth::user()->state_id;
            
            $stock = Stock::with('item.gst_percent')->where('item_id',$request->item_id)->first();
            $tax = ($stock['price_for_user'] * $stock->gst_percent->percent)/100;
            if($billing_user['state_id'] == $seller_user){
                // scgst
                $input['scgst'] = round($tax/2,2);
            }else{
                // igst
                $input['igst'] = round($tax,2);
            }

            $total_cost = $input['distributed_quantity'] * $stock['price_for_user'];

            $input['invoice_no'] = generate_invoice_no();
            $input['product_price'] = $stock['price_for_user'];
            $input['total_cost'] = $total_cost + $tax;
            $input['created_by'] = Auth::id();
            
            $dist = new Distribution();
            $dist->create($input);

            $stock->decrement('prod_quantity',$input['distributed_quantity']);

        } catch (\Illuminate\Database\QueryException $th) {
            DB::rollback();
            return back()->with('success','Something went wrong: '.$th->getMessage());
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
        $dis = Distribution::findOrFail($id);
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
        
        $dis = Distribution::findOrFail($id);
        $inv_no = getInvoiceNo($id);
        return view('distributer.invoice',compact('dis','inv_no'));
    }
}

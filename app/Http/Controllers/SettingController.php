<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\InvoiceSetting;
use App\Models\BillingSetting;
use Auth;

class SettingController extends Controller
{
    public function invoice_master(){

        $invoice_setting = InvoiceSetting::all();
        return view('setting.invoice_master',compact('invoice_setting'));
    }

    public function save_invoice_master(Request $request){
        try {

            $this->validate($request,[
                'prefix.*' => 'required|distinct',
                'suffix_number_length.*' => 'required|numeric|gt:0'
            ],[
                'prefix.*.required' => 'This is required',
                'prefix.*.distinct' => 'Prefix is already used',
                'suffix_number_length.*.required' => 'This is required',
                'suffix_number_length.*.numeric' => 'This field accept number only',
                'suffix_number_length.*.gt' => 'Enter value greater than 0',
            ]);
            
            DB::beginTransaction();
            
            $input = $request->all();
            
            foreach($input['prefix'] as $ind => $value){
                // update
                $inv = InvoiceSetting::find($ind);
                $inv->update([
                    'prefix'=>$value,
                    'suffix_number_length'=> $input['suffix_number_length'][$ind],
                    'updated_by' => Auth::id()
                ]);
            }
            
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return back()->with('Some Error Occurred : '.$ex->getMessage());
        }

        DB::commit();
        return back()->with('success','Invoice Setting is updated');
    }


    public function billing_master(){
        $billing_setting = BillingSetting::first();
        return view('setting.billing_master',compact('billing_setting'));
    }

    public function save_billing_master(Request $request){
        try {
            $this->validate($request,[
                'details' => 'required',
            ],[
                'details.required' => 'This is required',
            ]);
            
            DB::beginTransaction();
            $bill = BillingSetting::first();
            $input = $request->all();
            
            if(!empty($bill)){
                // update
                $bill->update($input);
            }else{
                // insert
                $bill_insert = new BillingSetting();
                $bill_insert->create($input);
                
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return back()->with('Some Error Occurred : '.$ex->getMessage());
        }
        DB::commit();
        return back()->with('success','Billing Address is updated');
    }
}

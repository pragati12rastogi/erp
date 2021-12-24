<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\InvoiceSetting;
use Auth;

class SettingController extends Controller
{
    public function invoice_master(){

        $invoice_setting = InvoiceSetting::first();
        return view('setting.invoice_master',compact('invoice_setting'));
    }

    public function save_invoice_master(Request $request){
        try {

            $this->validate($request,[
                'prefix' => 'required',
                'suffix_number_length' => 'required|numeric|gt:0'
            ],[
                'prefix.required' => 'This is required',
                'suffix_number_length.required' => 'This is required',
                'suffix_number_length.numeric' => 'This field accept number only',
                'suffix_number_length.gt' => 'Enter value greater than 0',
            ]);
            
            DB::beginTransaction();
            $inv = InvoiceSetting::first();
            $input = $request->all();
            $input['updated_by'] = Auth::id();
            if(!empty($inv)){
                // update
                $inv->update($input);
            }else{
                // insert
                $inv_insert = new InvoiceSetting();
                $inv_insert->create($input);
                
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return back()->with('Some Error Occurred : '.$ex->getMessage());
        }

        DB::commit();
        return back()->with('success','Invoice Setting is updated');
    }
}

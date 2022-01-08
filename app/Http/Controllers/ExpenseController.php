<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;
use App\Models\Expense;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::where('created_by',Auth::id())->get();

        return view('expenses.index',compact('expenses'));
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
        try {
            $input = $request->all();
            $validation = Validator::make($input,[
                'name' => 'required',
                'amount' => 'required',
                'datetime' => 'required'
            ],[
                'name.required' => 'Name is required',
                'amount.required' => 'Amount is required',
                'datetime.required' => 'Date Time is required'

            ]);

            if($validation->fails()){
                $error = $validation->errors();
                $message = '';
                foreach ($validation_arr->all() as $key => $value) {
                    $message .= $value.' ';
                }
                return back()->with('error',$message);
            }

            DB::beginTransaction();

            $insert = new Expense();
            $input['created_by'] = Auth::id();

            $insert->create($input);

        } catch (\Illuminate\Database\QueryException $th) {
            DB::rollback();
            return back()->with('error','Something went wrong '.$th->getMessage());
        }
        DB::commit();
        return back()->with('success','Expense is created successfully');
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
        $expense = Expense::findOrFail($id);
        $expense['datetime'] = str_replace(' ','T',$expense['datetime']);
        echo json_encode(compact('expense'));
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
                'name' => 'required',
                'amount' => 'required',
                'datetime' => 'required'
            ],[
                'name.required' => 'Name is required',
                'amount.required' => 'Amount is required',
                'datetime.required' => 'Date Time is required'

            ]);

            if($validation->fails()){
                $error = $validation->errors();
                $message = '';
                foreach ($validation_arr->all() as $key => $value) {
                    $message .= $value.' ';
                }
                return back()->with('error',$message);
            }

            DB::beginTransaction();

            $update = Expense::findorFail($id);
            $update->update($input);


        } catch (\Illuminate\Database\QueryException $th) {
            DB::rollback();
            return back()->with('error','Something went wrong '.$th->getMessage());
        }
        DB::commit();
        return back()->with('success','Expense is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);

        $value = $expense->delete();
        if ($value) {
            return back()->with('success','Expense is deleted successfully.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserStock;
use App\Models\UserStockDistributionItem;
use App\Models\UserStockDistributionOrder;
use App\Models\DistributionOrder;
use DB;
use Auth;
use Validator;


class UserDistributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $given_distribution = UserStockDistributionOrder::where('created_by',Auth::id())->get();
        $taken_distribution = DistributionOrder::where('user_id',Auth::id())->get();
        
        return view('user_stock.distribution_index',compact('given_distribution','taken_distribution'));
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
        //
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
        //
    }


    public function users_stock_list(){
        $user_stock = UserStock::where('user_id',Auth::id())->get();
        return view('user_stock.stock_list',compact('user_stock'));
    }
}

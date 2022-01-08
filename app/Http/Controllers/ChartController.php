<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Validator;
use App\Models\Expense;

class ChartController extends Controller
{
    public function index(){
        return view('charts.index');
    }
}

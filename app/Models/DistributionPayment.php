<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionPayment extends Model
{
    use HasFactory;

    protected $fillable = ['admin_order_id','local_order_id','amount','transaction_type','transaction_id','cheque_no','bank_name','ifsc','account_name','created_by'];
}

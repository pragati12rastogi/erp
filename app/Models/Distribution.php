<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_no','role_id','user_id','item_id','product_price','igst','scgst','total_cost','distributed_quantity','created_by','updated_by','is_cancelled'];

    public function role(){
        return $this->belongsTo(Role::class,'role_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function item(){
        return $this->belongsTo(Item::class,'item_id','id');
    }

    public function created_by_user(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function updated_by_user(){
        return $this->belongsTo(User::class,'updated_by','id');
    }

}

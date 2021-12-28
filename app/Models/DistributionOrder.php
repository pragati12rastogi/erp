<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionOrder extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_no','role_id','user_id','total_cost','total_tax','created_by'];
    
    public function role(){
        return $this->belongsTo(Role::class,'role_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function created_by_user(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function updated_by_user(){
        return $this->belongsTo(User::class,'updated_by','id');
    }

    public function invoices(){
        return $this->hasMany(Distribution::class,'order_id');
    }
}

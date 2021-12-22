<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = ['name','category_id','image','gst_percent_id','hsn_id'];

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id','id');
    }
    
    public function gst_percent(){
        return $this->belongsTo('App\Models\GstPercent','gst_percent_id','id');
    }
    
    public function hsn(){
        return $this->belongsTo('App\Models\Hsn','hsn_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSetting extends Model
{
    use HasFactory;

    public $table = 'invoice_settings';
    protected $fillable = ['prefix','suffix_number_length','updated_by'];
    

    public function updated_by_user(){
        return $this->belongsTo(User::class,'updated_by','id');
    }
}

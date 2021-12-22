<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Hsn extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public $table = "hsn";
    protected $fillable = ['hsn_no'];
}

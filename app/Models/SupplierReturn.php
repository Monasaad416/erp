<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierReturn extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];


    
    const RETURN_ITEM = 1;
    const PARTIALLY_RETURN_ITEM = 2;
}

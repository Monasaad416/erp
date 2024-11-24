<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Commission extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }

}

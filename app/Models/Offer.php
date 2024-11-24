<?php

namespace App\Models;

use App\Models\BranchOffer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','from_date','to_date','description','price','percentage'] ;

    public function branchOffer()
    {
       return $this->hasMany(BranchOffer::class);
    }

    public function product()
    {
       return $this->belongsTo('App\Models\Product')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
       ->withDefault([
        'name' => $this->product_name ,
       ]);
    }
}

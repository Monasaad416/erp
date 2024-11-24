<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CustomerReturnItem extends Pivot
{
    use HasFactory;
    protected $table="customer_return_items";
    protected $incremanting = true;
    public function product()
    {
       return $this->belongsTo('App\Models\Product')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','product_code')
       ->withDefault([
        'name' => $this->product_name ,
       ]);
    }

    public function customerReturn()
    {
       return $this->belongsTo('App\Models\CustomerReturn');
    }
    

    


}

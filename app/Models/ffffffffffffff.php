<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class fffffffffffff extends Pivot
{
    use HasFactory ,SoftDeletes;

    protected $table="customer_invoice_items";
    protected $incremanting = true;

    const RETURN_ITEM = 1;
    const PARTIALLY_RETURN_ITEM = 2;

    public function return_status_label()
    {
        return match($this->return_status)
        {
            self::RETURN_ITEM => trans('admin.return_item'),
            self::PARTIALLY_RETURN_ITEM => trans('admin.partially_return_item'),
            default => 'unknown',
        };
    }

    use HasFactory;
    // protected $fillable=['product_name','product_code','qty'];


    public function product()
    {
       return $this->belongsTo('App\Models\Product')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','product_code')
       ->withDefault([
        'name' => $this->product_name ,
       ]);
    }

    public function customerInvoice()
    {
       return $this->belongsTo(CustomerInvoice::class);
    }


    public function unit ()
    {
        return $this->belongsTo(Unit::class, 'unit_id','id');
    }
}

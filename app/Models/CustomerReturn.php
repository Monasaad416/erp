<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CustomerReturn extends Model
{
    use HasFactory;
    const RETURNE_INVOICE = 1;
    const RETURN_ITEM = 2;
     const RETURN_ITEM_PARTIALLY = 3;

    protected $guarded = ['id','created_at','updated_at'];
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','phone','street_name_'.LaravelLocalization::getCurrentLocale().' as street_name','cost_center_id')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }

        public function products ()
    {
        return $this->belongsToMany(Product::class, 'customer_invoice_items')

        ->using(CustomerInvoiceItem::class)
        ->withPivot('qty','unit','product_name_ar','product_name_en','product_code','total_without_tax','tax','total_with_tax','return_status','created_at','updated_at','deleted_at');
    }


    


}

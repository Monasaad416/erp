<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Inventory extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    // public function product()
    // {
    //     return $this->belongsTo(Product::class, 'product_id');
    // }

    public function store()
    {
        return $this->belongsTo(Store::class)->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }


    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function inventorable()
    {
        return $this->morphTo();
    }

    public function product()
    {
       return $this->belongsTo(Product::class,'product_id')::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','category_id','serial_num','unit_id','is_active','alert_main_branch','alert_branch',
            'sale_price','commission_rate')->withDefault([
        'name' => '---' ,
       ]);
    }
    public function branch()
    {
       return $this->belongsTo(Branch::class,'branch_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
       ->withDefault([
        'name' => '---' ,
       ]);
    }




}

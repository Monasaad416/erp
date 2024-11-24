<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ShortComing extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

       public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }


           public function branch()
    {
        return $this->belongsTo(Branch::class, 'category_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }

}

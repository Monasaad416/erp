<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CostCenter extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];
    public function parent()
    {
        return $this->belongsTo(CostCenter::class, 'parent_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','parent_id')
        ->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }

    public function children()
    {
        return $this->hasMany(CostCenter::class, 'parent_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','parent_id');
    }

    
}

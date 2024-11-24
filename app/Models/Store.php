<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Store extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','is_active')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }
}

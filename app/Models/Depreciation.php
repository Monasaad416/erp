<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Depreciation extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function asset()
    {
        return $this->belongsTo(Asset::class,'asset_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }
}

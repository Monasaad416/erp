<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Capital extends Model
{
    use HasFactory , SoftDeletes;
    protected $guarded = ['id','created_at','updated_at'];

    public function cabitalizable()
    {
        return $this->morphTo();
    }


    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }

}

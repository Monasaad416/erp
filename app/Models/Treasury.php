<?php

namespace App\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Treasury extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','is_active','branch_num')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }


    public function capitals()
    {
        return $this->morphMany(Capital::class, 'capitalizable');
    }

    
    public function withdrawalSources()
    {
        return $this->morphMany(PartnerWithdrawal::class, 'sourcable');
    }


}

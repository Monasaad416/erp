<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PartnerWithdrawal extends Model
{
    use HasFactory;

    protected $fillable = ['partner_id','amount','date','type','sourcable_type','sourcable_id','created_by','updated_by'];
    public function sourcable()
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

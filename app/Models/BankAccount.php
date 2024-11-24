<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class BankAccount extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function bank()
    {
        return $this->belongsTo(Bank::class,'bank_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }


    public function accountable()
    {
        return $this->morphTo();
    }

}

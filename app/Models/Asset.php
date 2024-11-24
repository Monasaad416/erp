<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Asset extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id','created_at','updated_at'];

    public function parentAccount()
    {
        return $this->belongsTo(Account::class, 'parent_account_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('id', 'name_' . LaravelLocalization::getCurrentLocale() . ' as name');
    }

}

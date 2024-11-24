<?php

namespace App\Models;

use App\Models\AccountType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Account extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id','created_at','updated_at'];
    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','parent_id')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }

    public function accountType()
    {
        return $this->belongsTo(AccountType::class, 'account_type_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }

    public function accountable(): MorphTo
    {
        return $this->morphTo();
    }
}

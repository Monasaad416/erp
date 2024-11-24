<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class IncomeList extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','level','account_num');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }
}

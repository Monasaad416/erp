<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TrailBalanceBefore extends Model
{
    use HasFactory;
protected $fillable=['account_id','account_num','debit','credit','balance','start_date','end_date','name_ar','name_en','branch_id'];
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','level','account_num');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }

    // public static function booted()
    // {
    //     static::creating(function(TrailBalanceBefore $entry){
    //         return $entry->financial_year_id = FinancialYear::where('year',Carbon::now()->format('Y'))->first()->id;
    //     });
    // }

}

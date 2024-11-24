<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Customer extends Model
{
    use HasFactory , SoftDeletes;
    protected $guarded = ['id','created_at','updated_at'];


    
    const BALANCED = 1;
    const DEBIT = 2;
    const CREDIT = 3;


    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }


    // public function account(): MorphOne
    // {
    //     return $this->morphOne(Account::class, 'accountable');
    // }

}

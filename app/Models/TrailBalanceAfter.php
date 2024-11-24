<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrailBalanceAfter extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public static function booted()
    {
        static::creating(function(TrailBalanceAfter $entry){
            return $entry->financial_year_id = FinancialYear::where('year',Carbon::now()->format('Y'))->first()->id;
        });
    }
}

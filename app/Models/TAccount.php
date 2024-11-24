<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TAccount extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];


    public function journalEntry()
    {
        return $this->belongsTo(JournalEntry::class, 'journal_entry_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }


    // public static function booted()
    // {
    //     static::creating(function(TAccount $entry){
    //         return $entry->financial_year_id = FinancialYear::where('year',Carbon::now()->format('Y'))->first()->id;
    //     });
    // }

}

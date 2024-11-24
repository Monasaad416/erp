<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\FinancialYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Ledger extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];



    public function journalEntry()
    {
        return $this->belongsTo(JournalEntry::class, 'journal_entry_id');
    }

    public function closingEntry()
    {
        return $this->belongsTo(ClosingEntry::class, 'closing_entry_id');
    }


    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }


    public static function booted()
    {
        static::creating(function(Ledger $entry){
            return $entry->is_checked = 0;
        });
    }
}

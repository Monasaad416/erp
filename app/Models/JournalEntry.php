<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class JournalEntry extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function journalable()
    {
        return $this->morphTo();
    }

    public function tAccounts()
    {
        return $this->hasMany(TAccount::class, 'journal_entry_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }

    public function debitAccount()
    {
        return $this->belongsTo(Account::class, 'debit_account_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }

    public function creditAccount()
    {
        return $this->belongsTo(Account::class, 'credit_account_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }



    // public static function booted()
    // {
    //     static::creating(function(JournalEntry $entry){
    //         return $entry->financial_year_id = FinancialYear::where('year',Carbon::now()->format('Y'))->first()->id;
    //     });
    // }



}

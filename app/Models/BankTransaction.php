<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class BankTransaction extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];
    
        public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }


        public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }



    public function journalEntries()
    {
        return $this->morphMany(JournalEntry::class, 'journalable');
    }

}

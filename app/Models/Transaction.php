<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Transaction extends Model
{
    use HasFactory;
     protected $guarded = ['id','created_at','updated_at'];

    public function treasuryShift()
    {
        return $this->belongsTo(TreasuryShift::class, 'treasury_shift_id')
        ->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }

    public function treasury()
    {
        return $this->belongsTo(Treasury::class, 'treasury_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }


    public function journalEntries()
    {
        return $this->morphMany(JournalEntry::class, 'journalable');
    }



}

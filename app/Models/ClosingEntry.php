<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ClosingEntry extends Model
{
    use HasFactory;

    
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

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\LaravelLocalization;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetSupplier extends Model
{
    use HasFactory;
    protected $fillable = ['name_ar', 'name_en', 'email', 'phone', 'tax_num', 'branch_id', 'account_num', 'start_balance', 'current_balance', 'balance_state', 'deleted_at'];
    public function sassetSupplierInvoices()
    {
        return $this->hasMany(AssetSupplierInvoice::class);
    }


    public function bankAcoounts()
    {
        return $this->morphMany(BankAccount::class, 'accountable');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('id', 'name_' . LaravelLocalization::getCurrentLocale() . ' as name');
    }
}

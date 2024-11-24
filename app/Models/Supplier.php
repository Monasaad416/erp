<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = ['name_ar','name_en','email','phone','gln','tax_num','branch_id','account_num','start_balance','current_balance','balance_state','deleted_at'];

    // public function account(): MorphOne
    // {
    //     return $this->morphOne(Account::class, 'accountable');
    // }

    public function supplierInvoices()
    {
        return $this->hasMany(SupplierInvoice::class);
    }


    public function bankAcoounts()
    {
        return $this->morphMany(BankAccount::class, 'accountable');
    }
}

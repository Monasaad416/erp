<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustingEntry extends Model
{
    use HasFactory;
    protected $fillable = ['debit_account_num',
            'credit_account_num',
            'debit_account_name_ar',
            'credit_account_name_ar',
            'debit_amount',
            'credit_amount',
            'description',
            'branch_id',
            'jounralable_type',
            'jounralable_id',
            'created_by',
            'updated_by'];
}

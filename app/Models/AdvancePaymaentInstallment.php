<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvancePaymaentInstallment extends Model
{
    use HasFactory;

    public function advancePayment()
    {
        return $this->belongsTo(AdvancePayment::class,'advance_payment_id')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }
}

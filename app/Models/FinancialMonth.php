<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialMonth extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];


    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function financialYear(){
        return $this->belongsTo(FinancialYear::class,'financial_year_id');
    }
}

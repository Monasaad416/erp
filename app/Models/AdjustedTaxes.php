<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AdjustedTaxes extends Model
{
    use HasFactory;

    
    protected $fillable = ['start_date','end_date','amount','adjust_date','branch_id','is_adjusted'];
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }
}

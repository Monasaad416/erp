<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }

      public function user()
    {
        return $this->belongsTo(User::class,'user_id')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }

    public function financialYear()
    {
        return $this->belongsTo(FinancialYear::class,'financial_year_id')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }
    public function financialMonth()
    {
        return $this->belongsTo(FinancialMonth::class,'financial_year_id')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }
}

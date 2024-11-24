<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniTrailBalanceBefore extends Model
{
    use HasFactory;
    protected $fillable=['account_id','account_num','debit','credit','balance','start_date','end_date','name_ar','name_en'];

       public function account()
    {
        return $this->belongsTo(Account::class, 'account_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','level','account_num');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('id', 'name_' . LaravelLocalization::getCurrentLocale() . ' as name');
    }
}

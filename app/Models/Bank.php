<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];



    public function capitals()
    {
        return $this->morphMany(Capital::class, 'capitalizable');
    }

    
    public function withdrawalSources()
    {
        return $this->morphMany(PartnerWithdrawal::class, 'sourcable');
    }
}

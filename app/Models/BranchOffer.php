<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class BranchOffer extends Pivot
{
    use HasFactory;

    protected $table="branch_offers";
    protected $incremanting = true;
    public function offer()
    {
       return $this->belongsTo('App\Models\Offer')
       ->withDefault([
            'description' => $this->description ,
       ]);
    }

    public function branch()
    {
       return $this->belongsTo('App\Models\Branch')
       ->withDefault([
            'description' => $this->description ,
       ]);
    }
}

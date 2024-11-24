<?php

namespace App\Models;

use App\Models\BranchOffer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Branch extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function treasury()
    {
        return $this->hasOne(Treasury::class);
    }
    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
        // ->withDefault([
        //     'name' => trans('admin.not_found'),
        // ]);
    }


    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function assetSuppliers()
    {
        return $this->hasMany(AssetSupplier::class);
    }
    public function branchOffer()
    {
       return $this->hasMany(BranchOffer::class);
    }

}

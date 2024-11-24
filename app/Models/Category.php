<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Category extends Model
{
    use HasFactory;
    protected $fillable=['name_ar','name_en','description_ar','description_en','parent_id','is_active'];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','parent_id')
        ->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','parent_id');
    }
}

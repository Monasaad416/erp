<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class InventoryTransaction extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function transItems()
    {
       return $this->hasMany(InventoryTransactionItem::class);
    }

    public function products ()
    {
        return $this->belongsToMany(Product::class, 'inventory_transaction_items')
        ->with('timestamps')
        ->using(InventoryTransactionItem::class)
        ->withPivot('qty','unit','unit_price','total_price','from_branch_new_balance','to_branch_new_balance','approval');
    }

    public function fromStore()
    {
        return $this->belongsTo(Store::class, 'from_store_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }

    public function toStore()
    {
        return $this->belongsTo(Store::class, 'to_store_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }


    public function journalEntries()
    {
        return $this->morphMany(JournalEntry::class, 'journalable');
    }





}

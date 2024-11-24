<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class InventoryTransactionItem extends Pivot
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

      protected $table="inventory_transaction_items";
    protected $incremanting = true;

    public function inventoryTransaction()
    {
       return $this->belongsTo(InventoryTransaction::class);
    }
    public function product()
    {
       return $this->belongsTo(Product::class);
    }



    public function inventories()
    {
        return $this->morphMany(Inventory::class, 'inventorable');
    }
}

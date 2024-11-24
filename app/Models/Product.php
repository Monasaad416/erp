<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\BranchProductsScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }


    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name');
    }


    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'product_id');
    }

    public function productCodes()
    {
        return $this->hasMany(ProductCode::class, 'product_id');
    }


    public function inventoryTransactions ()
    {
        return $this->belongsToMany(InventoryTransaction::class, 'inventory_transaction_items')
        ->with('timestamps')
        ->using(InventoryTransactionItem::class)
        ->withPivot('qty','unit','unit_price','total_price','from_branch_new_balance','to_branch_new_balance','approval');
    }


    public function customerInvoices ()
    {
        return $this->belongsToMany(CustomerInvoice::class, 'customer_invoice_items')
        ->with('timestamps')
        ->using(CustomerInvoiceItem::class)
        ->withPivot('qty','unit','unit_price','total_price','from_branch_new_balance','to_branch_new_balance','approval');
    }
     public function customerReturns ()
    {
        return $this->belongsToMany(CustomerReturn::class, 'customer_return_items')
        ->with('timestamps')
        ->using(CustomerReturnItem::class)
        ->withPivot('qty','unit','unit_price','total_price','from_branch_new_balance','to_branch_new_balance','approval');
    }


    public function supplierInvoices ()
    {
        return $this->belongsToMany(CustomerInvoice::class, 'supplier_invoice_items')
        ->with('timestamps')
        ->using(SupplierInvoiceItem::class)
        ->withPivot('qty','unit','unit_price','total_price','from_branch_new_balance','to_branch_new_balance','approval');
    }

    // public static function booted()
    // {
    //     static::addGlobalScope('branch', new BranchProductsScope());
    // }
     public function commission()
    {
        return $this->hasOne(Commission::class, 'product_id');
    }


}

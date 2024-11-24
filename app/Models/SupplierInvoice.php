<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SupplierInvoice extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [ "supp_inv_num" ,
    "serial_num","supp_inv_date_time" , "supplier_id" ,"is_approved" ,"is_pending","transportation_fees","created_by","payment_type" ,
    "discount_percentage" ,"supp_balance_before_invoice","branch_id","bank_id" ,"check_num","updated_at" , "created_at","id",
    "tax_value" ,"total_before_discount" ,"total_after_discount","discount_value" ,"tax_after_discount","supp_balance_after_invoice","status" ,"paid_amount" ];
    const UNPAID = 1;
    const PAID = 2;
    const PARTIALLY_PAID = 3;
    const DESERVED = 4;
    const PAID_IN_ADVANCE = 5;


    const RETURNE_INVOICE = 10;
    const RETURN_ITEM = 11;
    // const PARTIALLY_RETURN_ITEM = 12;





    public function status_label()
    {
        return match($this->status)
        {
            self::UNPAID => trans('admin.unpaid'),
            self::PAID => trans('admin.paid'),
            self::PARTIALLY_PAID => trans('admin.partially_paid'),
            self::DESERVED => trans('admin.desrved'),
            self::PAID_IN_ADVANCE => trans('admin.paid_in_advance'),
            default => 'unknown',
        };
    }

    public function return_status_label()
    {
        return match($this->return_status)
        {
            self::RETURNE_INVOICE => trans('admin.return_invoice'),
            self::RETURN_ITEM => trans('admin.return_item'),
            // self::PARTIALLY_RETURN_ITEM => trans('admin.partially_return_item'),
            default => 'unknown',
        };
    }
    // 'unpaid','paid','partially_paid','returned','partially_returned'

    //'invoice_type',['burchase','return_from_same_invoice','retun_in_general']

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
        ->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }

    public function products ()
    {
        return $this->belongsToMany(Product::class, 'customer_invoice_items')
        ->with('timestamps')
        ->using(CustomerInvoiceItem::class)
        ->withPivot('qty','unit','unit_price','total_price','from_branch_new_balance','to_branch_new_balance','approval');
    }


    public function supplierInvoiceItems()
    {
       return $this->hasMany(SupplierInvoiceItem::class);
    }

    public function shiftTranactions()
    {
        return $this->morphMany('App\Models\ShiftTranactions', 'shiftTransactionable');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function journalEntries()
    {
        return $this->morphMany(JournalEntry::class, 'journalable');
    }


    protected function suppInvNum(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => "S-". $value,
        );
    }
}

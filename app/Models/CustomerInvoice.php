<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CustomerInvoice extends Model
{
    use HasFactory,SoftDeletes;

   protected $guarded = ['id','created_at','updated_at'];
    const UNPAID = 1;
    const PAID = 2;
    const RETURNE_INVOICE = 10;
    const RETURN_ITEM = 11;
   const DELETED_INVOICE = 12;





    public function status_label()
    {
        return match($this->status)
        {
            self::UNPAID => trans('admin.unpaid'),
            self::PAID => trans('admin.paid'),
            default => 'unknown',
        };
    }



    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','phone','street_name_'.LaravelLocalization::getCurrentLocale().' as street_name','cost_center_id')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }

    public function zatca_documents()
    {
        return $this->hasMany(ZatcaDocument::class, 'invoice_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id')->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->withDefault([
            'name' => trans('admin.not_found'),
        ]);
    }
    // public function user()
    // {
    //     return $this->belongsTo(User::class,'user_id')->withDefault([
    //         'name' => trans('admin.not_found'),
    //     ]);
    // }


    public function products ()
    {
        return $this->belongsToMany(Product::class, 'customer_invoice_items')

        ->using(CustomerInvoiceItem::class)
        ->withPivot('qty','unit','product_name_ar','product_name_en','product_code','total_without_tax','tax','total_with_tax','return_status','created_at','updated_at','deleted_at');
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


    // protected function customerInvNum(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (?string $value) => "C-" . ($value ?? ''),
    //     );
    // }


}

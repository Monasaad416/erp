<?php

namespace App\Imports;

use App\Models\Unit;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductsImport implements ToModel,WithHeadingRow, WithHeadings
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $categories,$units,$suppliers;

    public function __construct()
    {
        $this->categories = Category::all();
        $this->units = Unit::all();
        $this->suppliers = Supplier::all();
    }

    public function model(array $row)
    {
        //dd( $row);
        $category = $this->categories->where( 'name_ar' , $row['altsnyf'])->first();
        $unit = $this->units->where( 'name_ar' , $row['alohd'])->first();
        $supplier = $this->suppliers->where( 'name_ar' , $row['almord'])->first();
        $product = new Product();
        $product->name_ar = $row['alasm_balaarby'];
        $product->name_en = $row['alasm_balanglyzy'];
        $product->sale_price = $row['saar_albyaa'];
        $product->category_id = $category->id ?? null;
        $product->unit_id = $unit->id ?? null;
        $product->supplier_id = $supplier->id ?? null;
        $product->fraction = $row['kabl_lltgzy'];
        $product->taxes = $row['aldrayb'];
        $product->alert_main_branch = $row['tnbyh_nks_alkmy_balmrkz_alryysy'];
        $product->alert_branch = $row['tnbyh_nks_alkmyh_balfraa'];
        $product->is_active = 1;
        $product->save();

        $inventory = new Inventory();
        $inventory->initial_balance = $row['alrsyd_alabtdayy'] ? $row['alrsyd_alabtdayy'] : 0;
        $inventory->inventory_balance =  $row['alrsyd_alhaly'] ? $row['alrsyd_alhaly']:0;
        $inventory->in_qty =  $row['alrsyd_alhaly'] ? $row['alrsyd_alhaly'] :0;
        $inventory->out_qty = 0;
        $inventory->current_financial_year = date("Y");
        $inventory->is_active = 1;
        $inventory->branch_id = 1;
        $inventory->store_id = 1;
        $inventory->product_id = $product->id;
        $inventory->updated_by = Auth::user()->id;
        $inventory->notes = ' إضافة منتج جديد للمخزن';
        $inventory->latest_purchase_price = $row['alrsyd_alhaly'] ? $row['alrsyd_alhaly'] : 0;
        $inventory->latest_sale_price = $row['saar_albyaa'];
        $inventory->inventorable_id = $product->id;
        $inventory->inventorable_type = 'App\Models\Product';
        $inventory->save();

        return [$product,$inventory];
    }

    public function headings(): array
    {
        return [
            'alasm_balaarby',
            'alasm_balanglyzy',
            'saar_albyaa',
            'altsnyf',
            'alohd',
            'almord',
            'kabl_lltgzy',
            'aldrayb',
            'tnbyh_nks_alkmy_balmrkz_alryysy',
            'tnbyh_nks_alkmyh_balfraa',
            'alrsyd_alabtdayy',
            'alrsyd_alhaly',
            'alrsyd_alhaly'
        ];
    }
}

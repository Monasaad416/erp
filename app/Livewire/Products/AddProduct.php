<?php

namespace App\Livewire\Products;

use Exception;
use App\Models\Unit;
use App\Models\Branch;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\ProductCode;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Products\DisplayProducts;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddProduct extends Component
{
    public $index,$categories,$units,$name_ar, $name_en, $unit_id,$category_id, $gtin,$manufactured_date,
    $expiry_date,$import_date,$size,$max_dose,$description,
    $purchase_price,$sale_price,$fraction,$taxes,$is_active ,$alert_main_branch,$alert_branch,$initial_balance=0,
    $inventory_balance=0,$addButtons = [''],$removeButtons=[''],$commission_rate,$latest_purchase_price,$latest_sale_price,$adjustedCodes=[];

    #[Validate]
    public $product_codes = [''];



    public function rules() {
        return [
            'name_ar' => ['required','string','max:255',Rule::unique('products')],
            'name_en' => ['nullable','string','max:255',Rule::unique('products')],
            'description' => 'nullable|string',
            'unit_id' => "required|exists:units,id",
            'category_id' => "required|exists:categories,id",
            'gtin' => ['nullable','string','gtin_length',
                Rule::unique('products')->where(function ($query) {
                    return $query->whereNotNull('gtin');
                }),
            ],
            'manufactured_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'import_date' => 'nullable|date',
            'size' => 'nullable|numeric',
            'max_dose' => 'nullable|numeric',
            'sale_price' => 'required|numeric|min:0',
            // 'discount_price' => 'nullable|numeric|min:0',
            'product_codes' => ['array'],
            // 'product_codes.*' => ['string','max:50',Rule::unique('product_codes')],
            'taxes' =>'nullable',
            'fraction' =>'nullable',
            'alert_main_branch' => 'nullable|numeric|min:0',
            'alert_branch' => 'nullable|numeric|min:0',
            'initial_balance' =>'nullable|numeric|min:0',
            'inventory_balance' =>'nullable|numeric|min:0',
            'commission_rate' =>'nullable|numeric|min:0|max:100',
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => trans('validation.name_ar_required'),
            'name_ar.string' => trans('validation.name_ar_string'),
            'name_ar.max' => trans('validation.name_ar_max'),
            'name_ar.unique' => trans('validation.name_ar_unique'),
            'name_en.string' => trans('validation.name_en_string'),
            'name_en.max' => trans('validation.name_en_max'),
            'name_en.unique' => trans('validation.name_en_unique'),
            'description.string' => trans('validation.description_ar_string'),
            'unit_id.required' => trans('validation.unit_id_required'),
            'unit_id.exists' => trans('validation.unit_id_exists'),
            'category_id.required' => trans('validation.parent_id_required'),
            'category_id.exists' => trans('validation.parent_id_exists'),
            'gtin.gtin_length' => trans('validation.gtin_length'),
            'sale_price.required' => trans('validation.sale_price_required'),
            'sale_price.numeric' => trans('validation.sale_price_numeric'),
            'sale_price.min' => trans('validation.sale_price_min'),
            'manufactured_date.date' => trans('validation.manufactured_date_date'),
            'expiry_date.date' => trans('validation.expiry_date_date'),
            'import_date.required' => trans('validation.import_date_required'),
            // 'discount_price.numeric' => trans('validation.discount_price_numeric'),
            // 'discount_price.min' => trans('validation.discount_price_min'),
            // 'initial_balance.required' => trans('validation.initial_balance_required'),
            // 'inventory_balance.required' => trans('validation.inventory_balance_required'),
            'initial_balance.numeric' => trans('validation.initial_balance_numeric'),
            'inventory_balance.numeric' => trans('validation.inventory_balance_numeric'),

            // 'alert_main_branch.required' => trans('validation.alert_main_branch_required'),
            // 'alert_branch.required' => trans('validation.alert_branch_required'),
            'alert_main_branch.numeric' => trans('validation.alert_main_branch_numeric'),
            'alert_branch.numeric' => trans('validation.alert_branch_numeric'),

            'commission_rate.numeric' => trans('validation.commission_rate_numeric'),
            'commission_rate.min' => trans('validation.commission_rate_min'),
            'commission_rate.max' => trans('validation.commission_rate_max'),


        ];

    }




public function addOnotherCode($index)
{
    $newIndex = $index + 1;
    $this->product_codes[$newIndex] = '';

}




    public function addAnotherCode()
    {
        $trimmedCode = substr(trim($this->product_codes[count($this->product_codes) - 1]), 2, 14);
        if (!empty($trimmedCode)) {
            $this->product_codes[] = $trimmedCode;
        }
    }

    public function removeCode($index)
    {
        unset($this->product_codes[$index]);

    }



    public static function getNextProdutSerial()
    {
        $currentSerial = Product::max('serial_num');
        if($currentSerial) {
            return $currentSerial + 1;
        }

        return '1';
    }


    public function adjustCode($index){
        $this->adjustedCodes = [];
        $codeExclude01 = substr($this->product_codes[$index], 2);
        $finalCode = substr($codeExclude01, 0, 14);
        $this->product_codes[$index] = $finalCode;
        $this->adjustedCodes[] = $finalCode;
    }
    public function create()
    {
        //dd($this->product_codes);

        $this->validate($this->rules() ,$this->messages());
        // try {

            DB::beginTransaction();
            //return dd($this->all());
            $product  = new Product();
            $product->name_ar = $this->name_ar;
            $product->name_en = $this->name_en;
            $product->gtin = $this->gtin;
            $product->serial_num = $this->getNextProdutSerial();
            $product->expiry_date = $this->expiry_date;
            $product->import_date = $this->import_date;
            $product->size = $this->size;
            $product->max_dose = $this->max_dose;
            $product->sale_price = $this->sale_price;
            // $product->discount_price = $this->discount_price;
            $product->alert_main_branch = $this->alert_main_branch;
            $product->alert_branch = $this->alert_branch;
            $product->unit_id = $this->unit_id;
            $product->category_id = $this->category_id;
            $product->description = $this->description;
            $product->fraction = $this->fraction;
            $product->taxes = $this->taxes;
            $product->is_active = 1;
            // $product->commission_rate = $this->commission_rate ? $this->commission_rate : 0;
            $product->save();

            //dd($this->adjustedCodes );
            foreach ($this->adjustedCodes as $index=>$code){
                if(!empty($code)){

                    $newCode = new ProductCode();
                    $newCode->code = $code;
                    $newCode->product_id = $product->id;
                    $newCode->save();
                }

            }

            $inventory = new Inventory();
            $inventory->initial_balance = $this->initial_balance ? $this->initial_balance : 0;
            $inventory->inventory_balance =  $this->inventory_balance ? $this->inventory_balance :0;
            $inventory->in_qty =  $this->inventory_balance ? $this->inventory_balance :0;
            $inventory->out_qty = 0;
            $inventory->current_financial_year = date("Y");
            $inventory->is_active = 1;
            $inventory->branch_id = 1;
            $inventory->store_id = 1;
            $inventory->product_id = $product->id;
            $inventory->updated_by = Auth::user()->id;
            $inventory->notes = ' إضافة منتج جديد للمخزن';
            $inventory->latest_purchase_price = $this->latest_purchase_price;
            $inventory->latest_sale_price = $this->sale_price;
            $inventory->inventorable_id = $product->id;
            $inventory->inventorable_type = 'App\Models\Product';
            $inventory->save();

            DB::commit();
            $this->reset(['name_ar','name_en','description','unit_id','category_id','gtin','sale_price',
                'manufactured_date','expiry_date','import_date','size','max_dose'
                ,'fraction','taxes','product_codes','initial_balance','inventory_balance','commission_rate','alert_branch','alert_main_branch']);

            $this->dispatch('createModalToggle');

            $this->dispatch('refreshData')->to(DisplayProducts::class);

            $this->dispatch(
           'alert',
                text: trans('admin.product_created_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')
            );


        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }



    }

    public function render()
    {
        return view('livewire.products.add-product');
    }
}

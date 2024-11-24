<?php

namespace App\Livewire\Products;

use App\Livewire\SupplierInvoices\AddInvoiceItems;
use Throwable;
use App\Models\Product;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\ProductCode;
use App\Models\InvoiceProduct;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\SupplierInvoiceItem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Suppliers\DisplaySuppliers;
use App\Livewire\SupplierInvoices\AddInvoice;
use App\Livewire\SupplierInvoices\ShowInvoice;
use App\Livewire\SupplierInvoices\DisplayInvoices;
use App\Livewire\SupplierInvoices\UpdateInvoice;

class UpdateProduct extends Component
{
    protected $listeners = ['updateProduct'];

    public $product,$productNameAr,$productNameEn,$categories,$units,$name_ar, $name_en, $unit_id,$category_id,$branch_id,
    $gtin,$serial_num,$manufactured_date,$expiry_date,$import_date,$size,$max_dose,$description,
    $sale_price,$discount_price, $fraction = 0,$taxes = 0,$is_active = 0 ,
    $product_id,$product_codes=[],$initial_balance=0,$inventory_balance=0;



    public function updateProduct($id)
    {
        $this->product_codes = ProductCode::where('product_id',$id)->pluck('code')->toArray();

        $this->product = Product::findOrFail($id);
        $this->product_id = $this->product->id;
        $this->productNameAr = $this->product->name_ar;
        $this->productNameEn= $this->product->name_en;


        $this->name_ar = $this->product->name_ar;
        $this->name_en = $this->product->name_en;

        $this->description = $this->product->description;
        $this->unit_id = $this->product->unit_id;
        $this->category_id = $this->product->category_id;
        $this->branch_id = $this->product->branch_id;
        $this->manufactured_date = $this->product->manufactured_date;
        $this->expiry_date = $this->product->expiry_date;
        $this->import_date = $this->product->import_date;
        $this->sale_price = $this->product->sale_price;
        $this->discount_price = $this->product->discount_price;
        $this->max_dose = $this->product->max_dose;
        $this->fraction = $this->product->fraction;
        $this->taxes = $this->product->taxes;
        $this->is_active = $this->product->is_active;
        $this->gtin = $this->product->gtin;
        $this->size = $this->product->size;
        $inventory =Inventory::where('product_id',$this->product->id)->latest()->first();
        //dd($inventory->initial_balance);
        $this->initial_balance = $inventory ?  $inventory->initial_balance : 0 ;
        $this->inventory_balance = $inventory  ?  $inventory->inventory_balance : 0 ;

        $this->resetValidation();

        //dispatch browser events (js)
        //add event to toggle edit modal after save
        $this->dispatch('editModalToggle');



    }

    public function rules() {
        return [
            'name_ar' => ['string','max:255',Rule::unique('products')->ignore($this->product->id, 'id')],
            'name_en' => ['nullable','string','max:255',Rule::unique('products')->ignore($this->product->id, 'id')],
            'description' => 'nullable|string',
            'unit_id' => "nullable|exists:units,id",
            'category_id' => "nullable|exists:categories,id",
            'gtin' => 'nullable|string|gtin_length',

            'manufactured_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'import_date' => 'nullable|date',
            'size' => 'nullable|numeric',
            'initial_balance' => 'nullable|numeric',
            'inventory_balance' => 'nullable|numeric',
            'max_dose' => 'nullable|numeric',
            'sale_price' => 'numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'is_active' => 'nullable',
            'fraction' => 'nullable',
            'taxes' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name_ar.string' => trans('validation.name_ar_string'),
            'name_ar.max' => trans('validation.name_ar_max'),
            'name_ar.unique' => trans('validation.name_ar_unique'),
            'name_en.string' => trans('validation.name_en_string'),
            'name_en.max' => trans('validation.name_en_max'),
            'name_en.unique' => trans('validation.name_en_unique'),
            'serial_num.string' => trans('validation.serial_num_string'),
            'serial_num.max' => trans('validation.serial_num_max'),
            'serial_num.unique' => trans('validation.serial_num_unique'),
            'description.string' => trans('validation.description_ar_string'),
            'unit_id.exists' => trans('validation.unit_id_exists'),
            'category_id.exists' => trans('validation.parent_id_exists'),
            'gtin.gtin_length' => trans('validation.gtin_length'),
            'sale_price.numeric' => trans('validation.sale_price_numeric'),
            'sale_price.min' => trans('validation.sale_price_min'),
            'manufactured_date.required' => trans('validation.manufactured_date_required'),
            'manufactured_date.date' => trans('validation.manufactured_date_date'),
            'expiry_date.date' => trans('validation.expiry_date_date'),
            'import_date.date' => trans('validation.import_date_date'),
            'discount_price.numeric' => trans('validation.discount_price_numeric'),
            'discount_price.min' => trans('validation.discount_price_min'),
            'inventory_balance.required' => trans('validation.inventory_balance_required'),
            'inventory_balance.numeric' => trans('validation.inventory_balance_numeric'),
            'is_active.required' => trans('validation.is_active_required'),
            'taxes.required' => trans('validation.taxes_required'),
            'fraction.required' => trans('validation.fraction_required'),
        ];

    }

//     public function addOnotherCode($index)
// {
//     $newIndex = $index + 1;
//     $this->product_codes[$newIndex] = '';

// }


public function addOnotherCode($index)
{
    $trimmedCode = substr(trim($this->product_codes[$index]), 2, 14);
    if (!empty($trimmedCode)) {
        $newIndex = $index + 1;
        $this->product_codes[$newIndex] = $trimmedCode;
    }
}

public function removeCode($index)
{
    unset($this->product_codes[$index]);

}


    public function update()
    {
        //DB::beginTransaction();
        // try {

        //update suppliers invoices items
        $suppInvoicesItems= SupplierInvoiceItem::where('product_id',$this->product->id)->get();
        //dd($suppInvoicesItems);

        if($suppInvoicesItems->count() > 0){
            $oldCodes = ProductCode::where('product_id',$this->product->id)->pluck('code')->toArray();
           //dd($this->product_codes);

            foreach($suppInvoicesItems as $item) {
                //dd($item->product_code);
                $itemCode = $item->product_code;
                if(in_array($item->product_code , $oldCodes)) {
                     $oldIndex = array_search($itemCode, $oldCodes);
                     $indexInNewCodes = array_search($itemCode, $this->product_codes);

                     if ($oldIndex !== false && $indexInNewCodes !== false) {
                        $oldValue = $oldCodes[$oldIndex];
                        $newValue = $this->product_codes[$indexInNewCodes];
                        dd($newValue);
                       if($oldValue !== $newValue) {
                            $codeExclude01 = substr($newValue, 2);
                            $finalCode = substr($codeExclude01, 0, 14);

                            $item->where('product_code',$oldValue)->first()->update([
                                'product_name_ar'=> $this->name_ar,
                                'product_name_en'=> $this->name_en,
                                'product_code'=> $finalCode,
                            ]);
                       }
                    }

                    // foreach($this->product_codes as $index => $code){

                    //     dd($this->product_codes[$index]);
                    //     if($this->product_codes[$index] == $oldCodes[$index]) {
                    //         //dd('ff');
                    //         $codeExclude01 = substr($this->product_codes[$index], 2);
                    //         $finalCode = substr($codeExclude01, 0, 14);

                    //     }
                    // }


                    $oldCodes = ProductCode::where('product_id',$this->product_id)->get();
                    //dd($oldCodes);
                    foreach ($oldCodes as $oldCode){
                        $oldCode->delete();
                    }
                    foreach ($this->product_codes as $index=>$code){
                        //dd($this->product_codes);
                            $codeExclude01 = substr($code, 2);
                            $finalCode = substr($codeExclude01, 0, 14);
                            ProductCode::create([
                                'code' =>$finalCode,
                                'product_id' => $this->product->id,
                            ]);
                    }

                } else {
                    $item->update([
                        'product_name_ar'=> $this->name_ar,
                        'product_name_en'=> $this->name_en,

                    ]);
                }
            }
        } else {
                $oldCodes = ProductCode::where('product_id',$this->product_id)->get();
                //dd($oldCodes);
                foreach ($oldCodes as $oldCode){
                    $oldCode->delete();
                }
                foreach ($this->product_codes as $index=>$code){
                    //dd($this->product_codes);
                        $codeExclude01 = substr($code, 2);
                        $finalCode = substr($codeExclude01, 0, 14);
                        ProductCode::create([
                            'code' =>$finalCode,
                            'product_id' => $this->product->id,
                        ]);
                }

        }




        //update inventort qty

        $inventory = Inventory::where('product_id',$this->product->id)->latest()->first();
        if($inventory) {
            $inventory->update([
                'initial_balance' => $this->initial_balance ? $this->initial_balance : 0,
                'inventory_balance' =>  $this->inventory_balance ? $this->inventory_balance :0,
                'current_financial_year' => date("Y"),
                'is_active' => 1,
                'product_id' => $this->product->id,
                'updated_by' => Auth::user()->id,
            ]);
        } else {
            Inventory::create([
                'initial_balance' => $this->initial_balance ? $this->initial_balance : 0,
                'inventory_balance' =>  $this->inventory_balance ? $this->inventory_balance :0,
                'current_financial_year' => date("Y"),
                'is_active' => 1,
                'product_id' => $this->product->id,
                'updated_by' => Auth::user()->id,
                'branch_id' => 1,
                'store_id' => 1,
                'notes' =>'إضافة منتح جديد للمخزن',
        ]);
        }


        //update product
        $data = $this->validate($this->rules() ,$this->messages());


        //update product codes

        $properties = ['fraction','taxes'];
//  foreach ($properties as $property) {
//     $value = $this->__get($property);

//     if ($value === true) {
//         $this->product->update([$property => 1]);
//     } else {
//         $this->product->update([$property => 0]);
//     }
// }

        $data = array_merge($this->validate($this->rules(), $this->messages()), ['is_active' => 1]);




            $this->product->update($data);

            DB::commit();

            $this->reset(['name_ar','name_en','description','unit_id','category_id','gtin','sale_price',
            'discount_price','manufactured_date','expiry_date','import_date','serial_num','size','max_dose'
            ,'fraction','taxes','is_active']);

            //dispatch browser events (js)
            //add event to toggle update modal after save
            $this->dispatch('editModalToggle');

            //refrsh data after adding update row
            $this->dispatch('refreshData')->to(DisplayProducts::class);
            $this->dispatch('refreshData')->to(UpdateInvoice::class);

            $this->dispatch(
            'alert',
                text: trans('admin.product_updated_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done'),
            );

        // } catch (Throwable $e) {
            //DB::rollback();
        //     report($e);
        //     return false;
        // }

    }

    public function render()
    {
        return view('livewire.products.update-product',['product', $this->product]);
    }
}

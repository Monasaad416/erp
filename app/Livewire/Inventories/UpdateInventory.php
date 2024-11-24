<?php

namespace App\Livewire\Inventories;

use Exception;
use App\Models\Product;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\ProductCode;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerInvoiceItem;
use App\Models\SupplierInvoiceItem;
use Illuminate\Support\Facades\Auth;
use Alert;

class UpdateInventory extends Component
{
        protected $listeners = ['updateProduct'];

    public $product,$productNameAr,$main_branch_inv,$branch1_inv,$branch2_inv,$branch3_inv,$branch4_inv, $branch5_inv,$branch6_inv,
    $main_branch,$branch1,$branch2,$branch3, $branch4, $branch5,$branch6,$latest_purchase_price;



    public function updateProduct($id)
    {
    
        $this->product = Product::findOrFail($id);
        $this->main_branch = Inventory::where('branch_id',1)->where('product_id',$id)->latest()->first();
        $this->branch1 = Inventory::where('branch_id',2)->where('product_id',$id)->latest()->first();
        $this->branch2 = Inventory::where('branch_id',3)->where('product_id',$id)->latest()->first();
        $this->branch3 = Inventory::where('branch_id',4)->where('product_id',$id)->latest()->first();
        $this->branch4 = Inventory::where('branch_id',5)->where('product_id',$id)->latest()->first();
        $this->branch5 = Inventory::where('branch_id',6)->where('product_id',$id)->latest()->first();
        $this->branch6 = Inventory::where('branch_id',7)->where('product_id',$id)->latest()->first();

        $this->main_branch_inv = $this->main_branch->inventory_balance ?? null;
        $this->branch1_inv = $this->branch1->inventory_balance ?? null;
        $this->branch2_inv = $this->branch2->inventory_balance ?? null;
        $this->branch3_inv = $this->branch3->inventory_balance ?? null;
        $this->branch4_inv = $this->branch4->inventory_balance ?? null;
        $this->branch5_inv = $this->branch5->inventory_balance ?? null;
        $this->branch6_inv = $this->branch6->inventory_balance ?? null;

        $this->latest_purchase_price = Inventory::where('branch_id',1)->where('product_id',$id)->latest()->first()->latest_purchase_price;

        $this->resetValidation();

        //dispatch browser events (js)
        //add event to toggle edit modal after save
        $this->dispatch('editModalToggle');

    }




        public function rules() {
        return [
            'latest_purchase_price' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'latest_purchase_price.required' => 'أخر سعر شراء للمنتج مطلوب',
            'latest_purchase_price.numeric' => 'أخر سعر شراء لابد أن يكون رقم',
        ];

    }


    public function update()
    {
         $this->validate($this->rules() ,$this->messages());
         //dd('jj');
        // try{
            DB::beginTransaction();
            if($this->main_branch_inv > 0 ){
            
                if($this->main_branch) {
                    //dd($this->main_branch);
                    $this->main_branch->inventory_balance = $this->main_branch_inv;
                    $this->main_branch->updated_by = Auth::user()->id;
                    $this->main_branch->latest_purchase_price = $this->latest_purchase_price ;
                    $this->main_branch ->save();
                } else {
                    Inventory::create([
                        'initial_balance' => 0,
                        'inventory_balance' =>  $this->main_branch_inv,
                        'in_qty' =>  $this->main_branch_inv,
                        'out_qty' => 0,
                        'current_financial_year' => date("Y"),
                        'is_active' => 1,
                        'product_id' => $this->product->id,
                        'branch_id' => 1,
                        'store_id' => 1,
                        'updated_by' => Auth::user()->id,
                        'notes' => 'تعديل كمية المخزون',
                        'latest_purchase_price' => $this->latest_purchase_price ,
                        'latest_sale_price' =>  CustomerInvoiceItem::where('product_id')->latest()->first()->sale_price ?? null,
                        'inventorable_id' => $this->product->id,
                        'inventorable_type' => 'App\Models\Product',
                    ]);
                }

                $this->product->update([
                    'inventory_balance' => $this->main_branch_inv,
                ]);
            }
            if($this->branch1_inv > 0 ){
                if($this->branch1) {
                    $this->branch1->inventory_balance = $this->branch1_inv;
                    $this->branch1->updated_by = Auth::user()->id;
                    $this->branch1->latest_purchase_price = $this->latest_purchase_price ;
                    $this->branch1 ->save();
                } else {
                    Inventory::create([
                        'initial_balance' => 0,
                        'inventory_balance' =>  $this->branch1_inv,
                        'in_qty' =>  $this->branch1_inv,
                        'out_qty' => 0,
                        'current_financial_year' => date("Y"),
                        'is_active' => 1,
                        'product_id' => $this->product->id,
                        'branch_id' => 2,
                        'store_id' => 2,
                        'updated_by' => Auth::user()->id,
                        'notes' => 'تعديل كمية المخزون',
                        'latest_purchase_price' => $this->latest_purchase_price ,
                        'latest_sale_price' =>  CustomerInvoiceItem::where('product_id')->latest()->first()->sale_price ?? null,
                        'inventorable_id' => $this->product->id,
                        'inventorable_type' => 'App\Models\Product',
                    ]);
                }
            }
            if($this->branch2_inv > 0 ){
                if($this->branch2) {
                    $this->branch2->inventory_balance = $this->branch2_inv;
                    $this->branch2->updated_by = Auth::user()->id;
                    $this->branch2->latest_purchase_price = $this->latest_purchase_price ;
                    $this->branch2 ->save();
                } else {
                    Inventory::create([
                        'initial_balance' => 0,
                        'inventory_balance' =>  $this->branch2_inv,
                        'in_qty' =>  $this->branch2_inv,
                        'out_qty' => 0,
                        'current_financial_year' => date("Y"),
                        'is_active' => 1,
                        'product_id' => $this->product->id,
                        'branch_id' => 3,
                        'store_id' => 3,
                        'updated_by' => Auth::user()->id,
                        'notes' => 'تعديل كمية المخزون',
                        'latest_purchase_price' => $this->latest_purchase_price ,
                        'latest_sale_price' =>  CustomerInvoiceItem::where('product_id')->latest()->first()->sale_price ?? null,
                        'inventorable_id' => $this->product->id,
                        'inventorable_type' => 'App\Models\Product',
                    ]);
                }
            }
            if($this->branch3_inv > 0 ){
                if($this->branch3) {
                    $this->branch3->inventory_balance = $this->branch3_inv;
                    $this->branch3->updated_by = Auth::user()->id;
                    $this->branch3->latest_purchase_price = $this->latest_purchase_price ;
                    $this->branch3 ->save();
                } else {
                    Inventory::create([
                        'initial_balance' => 0,
                        'inventory_balance' =>  $this->branch3_inv,
                        'in_qty' =>  $this->branch3_inv,
                        'out_qty' => 0,
                        'current_financial_year' => date("Y"),
                        'is_active' => 1,
                        'product_id' => $this->product->id,
                        'branch_id' => 4,
                        'store_id' => 4,
                        'updated_by' => Auth::user()->id,
                        'notes' => 'تعديل كمية المخزون',
                        'latest_purchase_price' => $this->latest_purchase_price ,
                        'latest_sale_price' =>  CustomerInvoiceItem::where('product_id')->latest()->first()->sale_price ?? null,
                        'inventorable_id' => $this->product->id,
                        'inventorable_type' => 'App\Models\Product',
                    ]);
                }
            }
            if($this->branch4_inv > 0 ){
                if($this->branch4) {
                    $this->branch4->inventory_balance = $this->branch4_inv;
                    $this->branch4->updated_by = Auth::user()->id;
                    $this->branch4->latest_purchase_price = $this->latest_purchase_price ;
                    $this->branch4 ->save();
                } else {
                    Inventory::create([
                        'initial_balance' => 0,
                        'inventory_balance' =>  $this->branch4_inv,
                        'in_qty' =>  $this->branch4_inv,
                        'out_qty' => 0,
                        'current_financial_year' => date("Y"),
                        'is_active' => 1,
                        'product_id' => $this->product->id,
                        'branch_id' => 5,
                        'store_id' => 5,
                        'updated_by' => Auth::user()->id,
                        'notes' => 'تعديل كمية المخزون',
                        'latest_purchase_price' => $this->latest_purchase_price ,
                        'latest_sale_price' =>  CustomerInvoiceItem::where('product_id')->latest()->first()->sale_price ?? null,
                        'inventorable_id' => $this->product->id,
                        'inventorable_type' => 'App\Models\Product',
                    ]);
                }
            }
            if($this->branch5_inv > 0 ){
                if($this->branch5) {
                    $this->branch5->inventory_balance = $this->branch5_inv;
                    $this->branch5->updated_by = Auth::user()->id;
                    $this->branch5->latest_purchase_price = $this->latest_purchase_price ;
                    $this->branch5 ->save();
                } else {
                    Inventory::create([
                        'initial_balance' => 0,
                        'inventory_balance' =>  $this->branch5_inv,
                        'in_qty' =>  $this->branch5_inv,
                        'out_qty' => 0,
                        'current_financial_year' => date("Y"),
                        'is_active' => 1,
                        'product_id' => $this->product->id,
                        'branch_id' => 6,
                        'store_id' => 6,
                        'updated_by' => Auth::user()->id,
                        'notes' => 'تعديل كمية المخزون',
                        'latest_purchase_price' => $this->latest_purchase_price ,
                        'latest_sale_price' =>  CustomerInvoiceItem::where('product_id')->latest()->first()->sale_price ?? null,
                        'inventorable_id' => $this->product->id,
                        'inventorable_type' => 'App\Models\Product',
                    ]);
                }
            }
            if($this->branch6_inv > 0 ){
                if($this->branch6) {
                    $this->branch6->inventory_balance = $this->branch6_inv;
                    $this->branch6->updated_by = Auth::user()->id;
                    $this->branch6->latest_purchase_price = $this->latest_purchase_price ;
                    $this->branch6 ->save();
                } else {
                    Inventory::create([
                        'initial_balance' => 0,
                        'inventory_balance' =>  $this->branch6_inv,
                        'in_qty' =>  $this->branch6_inv,
                        'out_qty' => 0,
                        'current_financial_year' => date("Y"),
                        'is_active' => 1,
                        'product_id' => $this->product->id,
                        'branch_id' => 7,
                        'store_id' => 6,
                        'updated_by' => Auth::user()->id,
                        'notes' => 'تعديل كمية المخزون',
                        'latest_purchase_price' => $this->latest_purchase_price ,
                        'latest_sale_price' =>  CustomerInvoiceItem::where('product_id')->latest()->first()->sale_price ?? null,
                        'inventorable_id' => $this->product->id,
                        'inventorable_type' => 'App\Models\Product',
                    ]);
                }
            }
         
            DB::commit();

            Alert::success('تم تعديل المخزون بنجاح');
            return redirect()->route('stores.inventory');
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }

    }

    public function render()
    {
        return view('livewire.inventories.update-inventory');
    }
}

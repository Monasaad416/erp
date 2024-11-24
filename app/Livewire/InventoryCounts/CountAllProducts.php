<?php

namespace App\Livewire\InventoryCounts;

use App\Models\Branch;
use App\Models\Product;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\ProductCode;
use App\Models\InventoryCount;
use App\Models\SupplierInvoiceItem;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Alert;

class CountAllProducts extends Component
{
    public $products=[],$rows=[],$inv_count_num,$branches,$product,$product_name_ar,$product_code,$product_name_en, $productCode,$productId,$unit,$actual_qty,$system_qty=0,
    $state='',$state_qty=0,$is_settled=0,$branch_id,$from_date,$to_date;

    public function mount()
    {

        $this->inv_count_num = getNextInvCountNum();


        $this->products = Product::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','unit_id','sale_price')->where('is_active',1)->get();

        $this->branches = Branch::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('is_active',1)->get();



    }
    public function rules()
    {
        foreach ($this->rows as $index => $row) {

            $rules['rows.' . $index . '.actual_qty'] = 'required|numeric';
        }

        return $rules;
    }

    public function messages()
    {
        return [

            'rows.*.actual_qty.required' => 'كمية الجرد الفعليه مطلوبة',
            'rows.*.actual_qty.numeric' =>  'كمية الجرد الفعليه يجب أن تكون رقم',
        ];
    }

    public function selectState($index)
    {
        if($this->rows[$index]['actual_qty'] > $this->rows[$index]['system_qty']){
         $this->rows[$index]['state'] = "فائض";
            $this->rows[$index]['state_qty'] = $this->rows[$index]['actual_qty'] -$this->rows[$index]['system_qty'];
        } elseif($this->rows[$index]['actual_qty'] < $this->rows[$index]['system_qty']) {
            $this->rows[$index]['state'] = "عجز";
            $this->rows[$index]['state_qty'] = (float)$this->rows[$index]['actual_qty'] -(float)$this->rows[$index]['system_qty'];
        }
         elseif($this->rows[$index]['actual_qty'] == $this->rows[$index]['system_qty']) {
            $this->rows[$index]['state'] = "متزن";
            $this->rows[$index]['state_qty'] = $this->rows[$index]['actual_qty'] -$this->rows[$index]['system_qty'];
        }
        //dd($this->rows[$index]['state'] );

    }


public function updated($propertyName)
{
    if (in_array($propertyName, ['branch_id', 'from_date', 'to_date'])) {
        
            $products = Product::all();
            if(Auth::user()->roles_name == 'سوبر-ادمن'){ 
                if ($this->branch_id && $this->from_date && $this->to_date) {
                    foreach ($products as $product) {
                        $inv = Inventory::where('product_id', $product->id)
                            ->where('branch_id', $this->branch_id)
                            ->whereBetween('created_at', [$this->from_date, $this->to_date])
                            ->latest()
                            ->first();


                            //dd($this->branch_id);

                        $code = ProductCode::where('product_id', $product->id)
                            ->latest()
                            ->first();

                        $item = [
                            'inv_count_number' => getNextInvCountNum(),
                            'product_name_en' => $product->name_en,
                            'product_name_ar' => $product->name_ar,
                            'product_code' => $code->code,
                            'product_id' => $product->id,
                            'unit' => $product->unit->name,
                            'system_qty' => $inv ? $inv->inventory_balance : 0,
                            'actual_qty' => '',
                            'latest_purchase_price' => $inv->latest_purchase_price,
                            'is_settled' => 0,
                        ];

                        $this->rows[] = $item;
                    }
                }
        } else {
            if ($this->from_date && $this->to_date) {
                foreach ($products as $product) {
                    $inv = Inventory::where('product_id', $product->id)
                        ->where('branch_id', Auth::user()->branch_id)
                        ->whereBetween('created_at', [$this->from_date, $this->to_date])
                        ->latest()
                        ->first();


                    $code = ProductCode::where('product_id', $product->id)
                        ->latest()
                        ->first();

                    $item = [
                        'inv_count_number' => getNextInvCountNum(),
                        'product_name_en' => $product->name_en,
                        'product_name_ar' => $product->name_ar,
                        'product_code' => $code->code,
                        'product_id' => $product->id,
                        'unit' => $product->unit->name,
                        'system_qty' => $inv ? $inv->inventory_balance : 0,
                        'actual_qty' => '',
                        'latest_purchase_price' => $inv->latest_purchase_price,
                        'is_settled' => 0,
                    ];

                    $this->rows[] = $item;
                }
            }
        }    
    }
}


    public function clearInputs ()
    {
        $this->product_code = "";
        $this->actual_qty = "";
        $this->product_name_ar = "";
    }
    public function removeItem($index)
    {
        unset($this->rows[$index -1]);
    }


    public function create() {
        $this->validate($this->rules() ,$this->messages());
    //\\dd($this->rows);

        // try{

        foreach($this->rows as $index=>$row) {
            $invCount = InventoryCount::create([

                'name_ar'=> $row['product_name_ar'],
                'product_code'=> $row['product_code'],
                'unit' => $row['unit'],
                'branch_id' => Auth::user()->roles_name == 'سوبر-ادمن' ? $this->branch_id : Auth::user()->branch_id ,
                'inv_count_num' => getNextInvCountNum(),
                // 'from_date'=>Carbon::parse($this->supp_inv_date_time)->format('Y-m-d H:i:s'),
                'from_date'=>$this->from_date,
                'to_date'=>$this->to_date,
                'actual_qty'=>$row['actual_qty'],
                'system_qty'=>$row['system_qty'],
                'state'=> $row['state'],
                'state_qty'=>$row['state_qty'],
                 'latest_purchase_price'=>$row['latest_purchase_price'],
            ]);
        }




        // $this->reset(['product_code','qty','product_name_ar','product_name_en','purchase_price','wholesale_inc_vat','discount_value','discount_percentage']);



        Alert::success('تم جرد المخزن عن الفترة المطلوبة بنجاح');
        return redirect()->route('stores.inventory_counts');




    //  } catch (Exception $e) {
    //         DB::rollback();
    //         return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
    //     }
    }
    public function render()
    {
        return view('livewire.inventory-counts.count-all-products');
    }
}

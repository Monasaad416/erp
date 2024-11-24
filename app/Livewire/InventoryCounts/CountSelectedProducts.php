<?php

namespace App\Livewire\InventoryCounts;

use Alert;
use Carbon\Carbon;
use App\Models\Branch;
use App\Models\Product;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\ProductCode;
use App\Models\InventoryCount;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CountSelectedProducts extends Component
{

   public $products=[],$rows=[],$inv_count_num,$branches,$product,$product_name_ar,$product_code,$product_name_en, $productCode,$productId,$unit,$actual_qty,$system_qty=0,
    $state='',$state_qty=0,$is_settled=0,$branch_id,$from_date,$to_date,$selectedProducts,$latest_purchase_ptice;

    public function mount()
    {


        $this->inv_count_num = getNextInvCountNum();

    $this->addRow(0);
        $this->dispatch('newRowAdded');


        $this->branches = Branch::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('is_active',1)->get();

    }

    public function updateState($index)
    {
        if($this->rows[$index]['actual_qty'] > $this->rows[$index]['system_qty']){
         $this->rows[$index]['state'] = "فائض";
            $this->rows[$index]['state_qty'] = $this->rows[$index]['actual_qty'] -$this->rows[$index]['system_qty'];
        } elseif($this->rows[$index]['actual_qty'] < $this->rows[$index]['system_qty']) {
            $this->rows[$index]['state'] = "عجز";
            $this->rows[$index]['state_qty'] = $this->rows[$index]['actual_qty'] -$this->rows[$index]['system_qty'];
        }
         elseif($this->rows[$index]['actual_qty'] == $this->rows[$index]['system_qty']) {
            $this->rows[$index]['state'] = "متزن";
            $this->rows[$index]['state_qty'] = $this->rows[$index]['actual_qty'] -$this->rows[$index]['system_qty'];
        }

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
            'payment_type.required' => trans('validation.payment_type_required'),
            'supplier_id.required' => trans('validation.supplier_id_required'),
            'supp_inv_date_time.required' => trans('validation.supp_inv_date_time_required'),
            'payment_type.in' => trans('validation.payment_type_in'),
            'status.required' => trans('validation.status_required'),
            'bank_id.required_if' => 'اختر البنك المطلوب صرف الشيك منه',
            'check_num.required_if' => 'ادخل رقم الشيك',
            'rows.*.product_code.required' => trans('validation.product_code_required'),
            'rows.*.product_code.string' => trans('validation.product_code_string'),
            'rows.*.product_code.max' => trans('validation.product_code_max'),
            'rows.*.product_code.exists' => trans('validation.product_code_exists'),
            'rows.*.purchase_price.required_if' => trans('validation.purchase_price_required_if'),
            'rows.*.wholesale_inc_vat.required_if' => trans('validation.wholesale_inc_vat_required_if'),
            'rows.*.wholesale_inc_vat.numeric' => trans('validation.wholesale_inc_vat_numeric'),
            'rows.*.purchase_price.min' => trans('validation.purchase_price_min'),
            'rows.*.purchase_price.gt' => 'سعر الشراء يجب أن يكون اكبر من 0',
            'rows.*.purchase_price.lt' => 'سعر الشراء يجب أن يكون اقل من سعر البيع',
            'rows.*.discount_percentage.numeric' => trans('validation.discount_percentage_numeric'),
            'rows.*.discount_value.numeric' => trans('validation.discount_value_numeric'),
            'rows.*.qty.required' => trans('validation.qty_required'),
            'rows.*.qty.numeric' => trans('validation.qty_numeric'),
        ];
    }

    public function clearInputs ()
    {
        $this->product_code = "";
        $this->unit = "";
        $this->actual_qty = "";
        $this->product_name_ar = "";
        $this->system_qty = 0;
        $this->state = "";
        $this->state_qty = 0;
        $this->from_date = "";
        $this->to_date = "";

    }

    public function focusNextRowInput($event, $index)
    {
        if ($index === count($this->rows) - 1) {

            $this->addRow();
            $this->dispatch('newRowAdded');
        }

        $nextIndex = $index + 1;
        $nextInputId = "input-" . $nextIndex;

        $this->dispatch('focus-input', ['inputId' => $nextInputId]);
    }
    public function addRow()
    {

        $this->rows[] = [
        'product_code' => "",
        'unit' => "",
        'actual_qty' => "",
        'product_name_ar' => "",
        'product_id' => "",
        'system_qty' => 0,
        'state' => "",
        'state_qty' => 0,
        'from_date' => "",
        'to_date' => "", 
        'latest_purchase_price' => 0,

        ];
         $this->dispatch('initialize-select2', ['index' => count($this->rows) - 1]);

        //     $this->dispatch('refreshJS');

    }

    public function removeItem($index)
    {
        unset($this->rows[$index -1]);
    }
    public function fetchByCode($index)
    {
        //dd($this->rows, $this->rows[$index]['product_name_ar']);
        $codeExclude01 = substr($this->rows[$index]['product_code'], 2);
        $finalCode = substr($codeExclude01, 0, 14);

        $this->rows[$index]['product_code'] = $finalCode;

        //dd($this->rows[$index]['product_code']);

        $this->validate([
            'rows.' . $index . '.product_code' => 'required|string|max:100|exists:product_codes,code',
        ]);

        // Retrieve the product name based on the product code
        $productCode = ProductCode::where('code', $this->rows[$index]['product_code'])->first();

        $product = Product::where('id', $productCode->product_id)->first();
        $inv = Inventory::where('product_id', $this->rows[$index]['product_id'])->where('branch_id',$this->branch_id)->whereBetween('created_at',[$this->from_date,$this->to_date])->latest()->first();
        //dd($product);
        $this->rows[$index]['product_name_ar'] =  $product->name_ar;
        $this->rows[$index]['product_name_en'] =  $product->name_en ;
        $this->rows[$index]['product_id'] =  $product->id ;
        $this->rows[$index]['unit'] =  $product->unit->name ;
        $this->rows[$index]['sale_price'] = $product->discount_price > 0  ? $product->discount_price : $product->sale_price ;
        $this->rows[$index]['latest_purchase_price'] =  $inv ? $inv->latest_purchase_price : 0;
        if(Auth::user()->roles_name == 'سوبر-ادمن'){
            $inv = Inventory::where('product_id', $product->id)->where('branch_id',$this->branch_id)->whereBetween('created_at',[$this->from_date,$this->to_date])->
            latest()->first();
            $code = ProductCode::where('product_id', $product->id)->latest()->first();
            //dd($code);
            $item = [
                'inv_count_number' => getNextInvCountNum(),
                'product_name_en' => $product->name_en,
                'product_name_ar' => $product->name_ar,
                'product_code' => $code->code,
                'product_id' =>$product->id,
                'unit' => $product->unit->name,
                'system_qty' => $inv ? $inv->inventory_balance : 0,
                'actual_qty' => "",
                'unit_price' => 0,
                'is_settled' => 0,
                'latest_purchase_price' => $inv->latest_purchase_price,
            ];

        } else {
            $inv = Inventory::where('product_id', $product->id)->where('branch_id',Auth::user()->branch_id)->whereBetween('created_at',[$this->from_date,$this->to_date])->
            latest()->first(); 
            //dd($inv);

                        $code = ProductCode::where('product_id', $product->id)->latest()->first();
            //dd($code);
            $item = [
                'inv_count_number' => getNextInvCountNum(),
                'product_name_en' => $product->name_en,
                'product_name_ar' => $product->name_ar,
                'product_code' => $code->code,
                'product_id' =>$product->id,
                'unit' => $product->unit->name,
                'system_qty' => $inv ? $inv->inventory_balance : 0,
                'actual_qty' => "",
                'unit_price' => 0,
                'is_settled' => 0,
                'latest_purchase_price' => $inv->latest_purchase_price,
            ];
        }


    }

// public function updated($propertyName)
// {
//     if (in_array($propertyName, ['branch_id', 'from_date', 'to_date'])) {
//         if ($this->branch_id && $this->from_date && $this->to_date) {
//             $product = Product::where('product_id', $product->id)
//                     ->where('branch_id', $this->branch_id)->first();
    
//                 $inv = Inventory::where('product_id', $product->id)
//                     ->where('branch_id', $this->branch_id)
//                     ->whereBetween('created_at', [$this->from_date, $this->to_date])
//                     ->latest()
//                     ->first();

//                 $code = ProductCode::where('product_id', $product->id)
//                     ->latest()
//                     ->first();

//                 $item = [
//                     'inv_count_number' => getNextInvCountNum(),
//                     'product_name_en' => $product->name_en,
//                     'product_name_ar' => $product->name_ar,
//                     'product_code' => $code->code,
//                     'product_id' => $product->id,
//                     'unit' => $product->unit->name,
//                     'system_qty' => $inv ? $inv->inventory_balance : 0,
//                     'actual_qty' => "",
//                     'unit_price' => 0,
//                     'is_settled' => 0,
//                 ];

//                 $this->rows[] = $item;
          
//         }
//     }
// }

    public function fetchByName($index, $selectedProductId)
    {
        // Fetch data and update properties
        //dd('dd');
        $product = Product::where('id', $selectedProductId)->first();
        //dd($product);
        if(Auth()->user()->roles_name == 'سوبر-ادمن') {
            $inv = Inventory::where('product_id', $product->id)->where('branch_id',$this->branch_id)->whereBetween('created_at',[$this->from_date,$this->to_date])->
        latest()->first();
        }  else {
            $inv = Inventory::where('product_id', $product->id)->where('branch_id',Auth::user()->branch_id)->whereBetween('created_at',[$this->from_date,$this->to_date])->
            latest()->first();
        }
        //dd($inv);
        $code = ProductCode::where('product_id', $product->id)->latest()->first();
       

        $this->rows[$index]['product_id'] = $product ? $product->id : trans('admin.not_found');
        $this->rows[$index]['unit'] = $product ? $product->unit->name : null;
        $this->rows[$index]['product_name_ar'] = $product ? $product->name_ar : null;
        $this->rows[$index]['product_code'] = $product ? ProductCode::where('product_id', $selectedProductId)->latest()->first()->code : null ;
        $this->rows[$index]['system_qty'] =  $inv ? $inv->inventory_balance : 0;
        $this->rows[$index]['latest_purchase_price'] =  $inv ? $inv->latest_purchase_price : 0;

    }

    
    public function selectState($index)
    {
        if($this->rows[$index]['actual_qty'] > $this->rows[$index]['system_qty']){
         $this->rows[$index]['state'] = "فائض";
            $this->rows[$index]['state_qty'] = $this->rows[$index]['actual_qty'] -$this->rows[$index]['system_qty'];
        } elseif($this->rows[$index]['actual_qty'] < $this->rows[$index]['system_qty']) {
            $this->rows[$index]['state'] = "عجز";
            $this->rows[$index]['state_qty'] = $this->rows[$index]['actual_qty'] -$this->rows[$index]['system_qty'];
        }
         elseif($this->rows[$index]['actual_qty'] == $this->rows[$index]['system_qty']) {
            $this->rows[$index]['state'] = "متزن";
            $this->rows[$index]['state_qty'] = $this->rows[$index]['actual_qty'] -$this->rows[$index]['system_qty'];
        }

    }
    public function create() {
        $this->validate($this->rules() ,$this->messages());
    //\\dd($this->rows);

        // try{

        foreach($this->rows as $index=>$row) {
            //dd($row);
            $invCount = InventoryCount::create([

                'name_ar'=> $row['product_name_ar'],
                'product_code'=> $row['product_code'],
                'unit' => $row['unit'],
                'branch_id' => Auth::user()->roles_name == 'سوبر-ادمن' ? $this->branch_id : Auth::user()->branch_id ,
                'inv_count_num' => getNextInvCountNum(),
                'from_date'=>$this->from_date,
                'to_date'=>$this->to_date,
                'actual_qty'=>$row['actual_qty'],
                'system_qty'=>$row['system_qty'],
                'state'=> $row['state'],
                'state_qty'=>$row['state_qty'],
                'latest_purchase_price'=> $row['latest_purchase_price'],
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
        return view('livewire.inventory-counts.count-selected-products');
    }
}

<?php

namespace App\Livewire\InventoryCounts;

use App\Models\Branch;
use App\Models\Product;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\ProductCode;
use App\Models\SupplierInvoiceItem;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddInventoryCount extends Component
{
      public $products=[],$rows=[],$inv_count_num,$branches,$product,$product_name_ar,$product_code,$product_name_en, $productCode,$productId,$unit,$actual_qty,$system_qty=0,
    $state='',$state_qty=0,$is_settled=0,$branch_id,$from_date,$to_date,$selectedProducts,$latest_purchase_price=0;
        public function mount()
    {


    $this->addRow(0);
        $this->dispatch('newRowAdded');


        $this->branches = Branch::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('is_active',1)->get();

    }

    public function addRow()
    {

        $this->rows[] = [
        'product_code' => "",
        'unit' => "",
        'actual_qty' => 0,
        'product_name_ar' => "",
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
        [
        'branch_id' => 'required|numeric',
        'from_date' => 'required|date',
        'to_date' => 'required|date',
        ];

    }

    public function messages()
    {
        return [

            'rows.*.actual_qty.required' => 'كمية الجرد الفعليه مطلوبة',
            'rows.*.actual_qty.numeric' =>  'كمية الجرد الفعليه يجب أن تكون رقم',
        ];
    }

    public function branchInvCount()
    {
        if($this->selectedProducts == 'الكل') {
            return view('livewire.inventory-counts.count-all-products');
        }elseif($this->selectedProducts == 'محددة') {
            return view('livewire.inventory-counts.count-selected-products')->with([
        'branch_id' => $this->branch_id,
        'from_date' => $this->from_date,
        'to_date' => $this->to_date,
    ]);
        }

    }

    public function adjustCode($index)
    {
        $codeExclude01 = substr($this->rows[$index]['product_code'], 2);
        //dd($codeExclude01);
        $finalCode = substr($codeExclude01, 0, 14);
        $this->rows[$index]['product_code'] = $finalCode;
        //dd($this->rows[$index]['product_code']);
        $this->fetchByCode($index);
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
        //dd($inv);
        $this->rows[$index]['product_name_ar'] =  $product->name_ar;
        $this->rows[$index]['product_name_en'] =  $product->name_en ;
        $this->rows[$index]['product_id'] =  $product->id ;
        $this->rows[$index]['unit'] =  $product->unit->name ;
        $this->rows[$index]['latest_purchase_price'] =  $inv->latest_purchase_price ;
        $this->rows[$index]['sale_price'] = $product->discount_price > 0  ? $product->discount_price : $product->sale_price ;

        $inv = Inventory::where('product_id', $product->id)->where('branch_id',$this->branch_id)->whereBetween('created_at',[$this->from_date,$this->to_date])->latest()->first();
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
            'actual_qty' => 0,
            'latest_purchase_price' => $inv->latest_purchase_price,
            'is_settled' => 0,
        ];
    }

    public function fetchByName($index, $selectedProductId)
    {
        // Fetch data and update properties
        //dd('dd');
        $product = Product::where('id', $selectedProductId)->first();
        //

        $inv = Inventory::where('product_id', $this->rows[$index]['product_id'])->where('branch_id',$this->branch_id)->whereBetween('created_at',[$this->from_date,$this->to_date])->latest()->first();

        $this->rows[$index]['product_id'] = $product ? $product->id : trans('admin.not_found');
        $this->rows[$index]['unit'] = $product ? $product->unit->name : null;
        $this->rows[$index]['product_name_ar'] = $product ? $product->name_ar : null;
        $this->rows[$index]['product_code'] = $product ? ProductCode::where('product_id', $selectedProductId)->latest()->first()->code : null ;
        $this->rows[$index]['latest_purchase_price'] = $inv->latest_purchase_price ;
        // dd($this->rows);
     
        //dd($inv);
        $code = ProductCode::where('product_id', $product->id)->latest()->first();
        //dd($code);
        $item = [
            'inv_count_number' => getNextInvCountNum(),
            'product_name_ar' => $this->rows[$index]['product_name_ar'],
            'product_code' => $this->rows[$index]['product_code'],
            'product_id' => $this->rows[$index]['product_id'],
            'unit' => $this->rows[$index]['unit'],
            'system_qty' => $inv ? $inv->inventory_balance : 0,
            'latest_purchase_price' => $inv->latest_purchase_price,
            'actual_qty' => 0,
            'state' => '',
            'state_qty' =>0,
        ];
        array_push($this->rows, $item);
    }




    public function render()
    {
        if(Auth::user()->roles_name == 'سوبر-ادمن') {
            return view('livewire.inventory-counts.add-inventory-count')->with([
                'branch_id' => $this->branch_id,
                'from_date' => $this->from_date,
                'to_date' => $this->to_date,
            ]);
        } else {
            return view('livewire.inventory-counts.add-inventory-count')->with([
                'branch_id' => $this->branch_id,
                'from_date' => $this->from_date,
                'to_date' => $this->to_date,
            ]);
        }

    }
}

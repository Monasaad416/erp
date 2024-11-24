<?php

namespace App\Livewire\StoresTransactions;

use Carbon\Carbon;
use App\Models\Store;
use App\Models\Product;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\ProductCode;
use Illuminate\Support\Facades\Auth;
use App\Models\InventoryTransactionItem;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UpdateStoreTransaction extends Component
{
    public $products=[] ,$rows=[],$product, $product_id,$product_name_ar, $product_code, $unit ,
            $trans_num,$trans_date_time,$approval=[],$from_store_id,$description,$to_store_id,$unit_price,$total_price,
            $finalItemPrice=0,$inventoryFromBalance = 0,$qty,$transaction;

    public $listeners = ['refreshData' =>'$refresh'];
    public function mount() {
        //dd($this->transaction);
        $this->trans_num = $this->transaction->trans_num;
        $this->trans_date_time = $this->transaction->trans_date_time;
        $this->from_store_id = $this->transaction->from_store_id;
        $this->to_store_id = $this->transaction->to_store_id;
        $this->description = $this->transaction->description;

        $this->addRow(0);
        $this->dispatch('newRowAdded');
        $this->products = Product::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','unit_id','sale_price')->where('is_active',1)->get();
    }

    public function rules()
    {
        $rules = [
            'trans_date_time' => 'nullable',
            'description' => 'nullable|string',
            'from_store_id' => 'nullable',
            'to_store_id' => 'nullable',
        ];

        foreach ($this->rows as $index => $row) {
            $rules['rows.' . $index . '.product_code'] = [
                'nullable',
                'string',
                'max:100',
                'exists:product_codes,code',
            ];
            $rules['rows.' . $index . '.qty'] = 'nullable|numeric|max:' . $this->rows[$index]['inventoryFromBalance'];
            $rules['rows.' . $index . '.unit_price'] = 'nullable';
            $rules['rows.' . $index . '.total_price'] = 'nullable';
            $rules['rows.' . $index . '.product_name_ar'] = 'nullable|string';
        }

        return $rules;
    }

    public function messages()
    {
        return [

            'rows.*.product_code.string' => trans('validation.product_code_string'),
            'rows.*.product_code.max' => trans('validation.product_code_max'),
            'rows.*.product_code.exists' => trans('validation.product_code_exists'),
            'rows.*.qty.numeric' => trans('validation.qty_numeric'),
            'rows.*.qty.max' => 'الكمية المطلوب تحويلها غير متوفره بالمخزن',
        ];
    }

    public function clearInputs ()
    {
        $this->product_code = "";
        $this->qty = "";
        $this->product_name_ar = "";
        $this->product_id = "";
        // $this->product_name_en = "";
        $this->unit_price = "";
        $this->total_price = "";
    }

    public function fetchByCode($index)
    {

        $codeExclude01 = substr($this->rows[$index]['product_code'], 2);
        $finalCode = substr($codeExclude01, 0, 14);

        $this->rows[$index]['product_code'] = $finalCode;

        //dd($this->rows[$index]['product_code']);

        $this->validate([
            'rows.' . $index . '.product_code' => 'required|string|max:100|exists:product_codes,code',
        ]);

        // Retrieve the product name based on the product code
        $productCode = ProductCode::where('code', $this->rows[$index]['product_code'])->first();
        //dd($productCode);
        $product = Product::where('id', $productCode->product_id)->first();
        //dd($product);

        $this->rows[$index]['product_name_ar'] = $product ? $product->name_ar : null;
        // $this->rows[$index]['product_name_en'] = $product ? $product->name_en : null;
        $this->rows[$index]['product_id'] = $product ? $product->id : trans('admin.not_found');
        $this->rows[$index]['unit'] = $product ? $product->unit->name : null;
        $this->rows[$index]['unit_price'] = $product ? $product->sale_price : null;

        $this->rows[$index]['inventoryFromBalance'] =  Inventory::where('product_id', $product->id)
        ->where('store_id',$this->from_store_id)->latest()->first()->inventory_balance;

        //dd( $this->rows[$index]['inventoryFromBalance']);


    }

    public function fetchByName($index, $selectedProductId)
    {
        // Fetch data and update properties
       //dd('dd');
        $product = Product::where('id', $selectedProductId)->first();

        $this->rows[$index]['product_id'] = $selectedProductId ;
        $this->rows[$index]['unit'] = $product ? $product->unit->name : null;
        $this->rows[$index]['unit_price'] = $product ? $product->sale_price : null;
        $this->rows[$index]['total_price'] = $product ? $product->total_price : null;
        // $this->rows[$index]['product_name_en'] = $product ? $product->product_name_en : null;

        $this->rows[$index]['product_code'] = ProductCode::where('product_id', $this->rows[$index]['product_id'])->latest()->first()->code;
    }

    public function focusNextRowInput($event, $index)
    {
        if ($index === count($this->rows) - 1) {
            $this->addRow();
        }

        $nextIndex = $index + 1;
        $nextInputId = "input-" . $nextIndex;


        $this->dispatch('focus-input', ['inputId' => $nextInputId]);
         $this->dispatch('newRowAdded');
    }
    public function addRow()
    {

        $this->rows[] = [
            'product_code' => '',
            'qty' => '',
            'product_name_ar' => '',
            // 'product_name_en' => '',
            'product_id' => '',
            'unit' => '',
            'total_price' => '',
            'unit_price' => '',
            'inventoryFromBalance' => '',
        ];



    }

    public function removeItem($index)
    {
        unset($this->rows[$index -1]);
    }


    public function update() {
        $this->validate($this->rules() ,$this->messages());
         //dd($this->all());
        //  DB::beginTransaction();
        // try{
        $this->validate($this->rules() ,$this->messages());

        $this->transaction->update([
            'trans_date_time'=>Carbon::parse($this->trans_date_time)->format('Y-m-d H:i:s'),
            'to_store_id'=>$this->to_store_id,

        ]);

        foreach ($this->rows as $index => $row) {
                     //from store inventory
                Inventory::create([
                    'initial_balance' => $fromStoreRow->initial_balance ,
                    'inventory_balance' =>  $qtyInFromStore - $this->accepted_qty,
                    'in_qty'=> 0,
                    'out_qty'=> $this->accepted_qty,
                    'current_financial_year' => date("Y"),
                    'is_active' => 1,
                    'branch_id' => Store::where('id',$this->from_store_id)->first()->branch->id,
                    'store_id' => $this->from_store_id,
                    'product_id' => $item->product_id,
                    'created_by' => Auth::user()->id,
                    'notes'=>'تحويل مخزني',
                    'inventorable_id' => $row->inventory_transaction_id,
                    'inventorable_type' => 'App\Models\InventoryTransactionItem',
                ]);

                //to store inventory
                Inventory::create([
                    'initial_balance' => $fromStoreRow->initial_balance ,
                    'inventory_balance' =>  $qtyInToStore + $this->accepted_qty,
                    'in_qty'=> $this->accepted_qty,
                    'out_qty'=> 0,
                    'current_financial_year' => date("Y"),
                    'is_active' => 1,
                    'branch_id' => Store::where('id',$this->to_store_id)->first()->branch->id,
                    'store_id' => $this->to_store_id,
                    'product_id' => $item->product_id,
                    'created_by' => Auth::user()->id,
                    'notes'=>'استلام مخزني',
                    'inventorable_id' => $row->inventory_transaction_id,
                    'inventorable_type' => 'App\Models\InventoryTransactionItem',
                ]);
            $toStoreRow = Inventory::where('product_id', $row['product_id'])
            ->where('store_id',$this->to_store_id)->latest()->first();
            $qtyInToStore = $toStoreRow ? $toStoreRow->inventory_balance : 0;
            $qtyInFromStore = $fromStoreRow->inventory_balance;
            //dd( $qtyInFromStore );

            //from store inventory
            Inventory::create([
                'initial_balance' => $fromStoreRow->initial_balance ,
                'inventory_balance' =>  $qtyInFromStore - $row['qty'],
                'in_qty'=> 0,
                'out_qty'=> $row['qty'],
                'current_financial_year' => date("Y"),
                'is_active' => 1,
                'branch_id' => Store::where('id',$this->from_store_id)->first()->branch->id,
                'store_id' => $this->from_store_id,
                'product_id' => $row['product_id'],
                'created_by' => Auth::user()->id,
                'notes'=>'تحويل مخزني',
                'inventorable_id' => $row->inventory_transaction_id,
                'inventorable_type' => 'App\Models\InventoryTransactionItem',
            ]);



            $invoiceItem = InventoryTransactionItem::create([
                'inventory_transaction_id' => $trans->id,
                'product_id' => $row['product_id'],
                'unit_price' => $row['unit_price'],
                'total_price' =>$row['unit_price'] * $row['qty'],
                'qty' => $row['qty'],
                'approval' =>'معلق',
                'from_branch_new_balance' => $qtyInFromStore - $row['qty'],
                'to_branch_new_balance' => $qtyInToStore , // other branch did not approve  yet
                'unit' => $row['unit'],
                'product_code' => $row['product_code'],
                'product_name_ar' => $row['product_name_ar'],
                'product_name_en' => $row['product_name_en'],
            ]);
        }

        $this->clearInputs();
        $this->reset(['product_code','qty','product_name_ar','unit_price','total_price']);

        // $this->dispatch('refreshData')->to(AddInvoice::class);


            // $this->dispatch(
            // 'alert',
            //     text: 'تم اضافة تحويل مخزني جديد',
            //     icon: 'success',
            //     confirmButtonText: trans('admin.done'),
            // );

            // redirect()->route('suppliers.invoices');

            // return redirect()->route('suppliers.invoices') ;

            DB::commit();
            Alert::success('تم اضافة تحويل مخزني جديد');
            redirect()->route('stores.transactions');

            //  } catch (Exception $e) {
            //         DB::rollback();
            //         return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
            //     }
    }


    public function render()
    {
        $transactionItems = InventoryTransactionItem::where('inventory_transaction_id',$this->transaction->id)->paginate(11);
        return view('livewire.stores-transactions.update-store-transaction',['transactionItems'=> $transactionItems]);
    }
}

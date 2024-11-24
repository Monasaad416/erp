<?php

namespace App\Livewire\StoresTransactions;

use Alert;
use App\Notifications\NewStoreTransaction;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\ProductCode;
use Illuminate\Support\Facades\DB;
use App\Events\CheckInventoryCount;
use App\Models\SupplierInvoiceItem;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\Auth;
use App\Models\InventoryTransactionItem;
use App\Events\InventoryTransactionEvent;
use App\Models\InventoryTransactionItems;
use Illuminate\Support\Facades\Notification;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddStoreTransaction extends Component
{
        public $products=[] ,$rows=[],$product, $product_id,$product_name_ar,$product_name_en, $product_code, $unit ,
       $trans_num,$trans_date_time,$approval,$from_store_id,$description,$to_store_id,$unit_price,$total_price,
        $finalItemPrice=0,$inventoryFromBalance = 0,$qty,$transaction;


    public function mount() {
        $this->clearInputs();
        $this->trans_num = $this->getNextTransactionNum();
        $this->trans_date_time = now()->format('Y-m-d\TH:i');
        $authUser = Auth::user();
        // if($authUser->roles_name != 'سوبر-ادمن') {
        //     $this->from_store_id = Store::where('id',Auth::user()->branch->store->id)->first()->id;
        // } else {

        // }

        $this->description = 'تحويل واستلام مخزني';
        $this->addRow(0);
        $this->dispatch('newRowAdded');
        $this->products = Product::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','unit_id','sale_price')->where('is_active',1)->get();


    }

    public function rules()
    {
        $rules = [
            'trans_date_time' => 'required',
            'description' => 'nullable|string',
            'from_store_id' => 'required',
            'to_store_id' => 'required',
        ];

        foreach ($this->rows as $index => $row) {
            $rules['rows.' . $index . '.product_code'] = [
                'required',
                'string',
                'max:100',
                'exists:product_codes,code',

            ];
            $rules['rows.' . $index . '.qty'] = 'required|numeric|max:' . $this->rows[$index]['inventoryFromBalance'];
            $rules['rows.' . $index . '.unit_price'] = 'required';
            $rules['rows.' . $index . '.total_price'] = 'nullable';
            $rules['rows.' . $index . '.product_name_ar'] = 'nullable|string';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'trans_date_time.required' => 'تاريخ وتوقيت التحويل مطلوب',
            'to_store_id.required' => ' المخزن المطلوب التحويل اليه مطلوب',
            'from_store_id.required' => ' المخزن المطلوب التحويل منه مطلوب',

            'rows.*.product_code.required' => trans('validation.product_code_required'),
            'rows.*.product_code.string' => trans('validation.product_code_string'),
            'rows.*.product_code.max' => trans('validation.product_code_max'),
            'rows.*.product_code.exists' => trans('validation.product_code_exists'),
            'rows.*.product_name_ar.required' => trans('validation.product_name_ar_required'),
            'rows.*.product_name_ar.unique' => 'تم اضافة  هذا المنتج الي التحويل الحالي',
            'rows.*.unit_price.required' => 'سعر الوحدة مطلوب',

            'rows.*.qty.required' => trans('validation.qty_required'),
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
        $this->product_name_en = "";
        $this->unit_price = "";
        $this->total_price = "";
    }

    public static function getNextTransactionNum()
    {
        $currentTransNumber = InventoryTransaction::max('trans_num');
        if($currentTransNumber) {
            return $currentTransNumber + 1;
        }

        return  1;
    }

    public function adjustCode($index)
    {
        $codeExclude01 = substr($this->rows[$index]['product_code'], 2);
        $finalCode = substr($codeExclude01, 0, 14);
        $this->rows[$index]['product_code'] = $finalCode;
        //dd($this->rows[$index]['product_code']);
        $this->fetchByCode($index);
    }
    public function fetchByCode($index)
    {

        if($this->from_store_id == null && $this->to_store_id == null){
            $this->mount();
            $this->dispatch(
                'alert',
                    text: 'فضلا إختر المخزن المحول منه والمخزن المحول اليه اولا',
                    icon: 'error',
                    confirmButtonText: trans('admin.done')

            );
        } else {
            $this->validate([
                'rows.' . $index . '.product_code' => 'required|string|max:100|exists:product_codes,code',
            ]);

            // Retrieve the product name based on the product code
            $productCode = ProductCode::where('code', $this->rows[$index]['product_code'])->first();

            $product = Product::where('id', $productCode->product_id)->first();
            $latestProduct = SupplierInvoiceItem::where('product_id',$product->id)->latest()->first();
            $purchasePrice = $latestProduct ? $latestProduct->purchase_price : $product->latest_purchase_price ;

            $invRow = Inventory::where('product_id', $product->id)
            ->where('store_id',$this->from_store_id)->latest()->first();
            $invFromBalance = $invRow ? $invRow->inventory_balance : 0;



            $this->rows[$index]['product_name_ar'] = $product ? $product->name_ar : 'لايوجد';
            $this->rows[$index]['product_name_en'] = $product ? $product->name_en : 'لايوجد';
            $this->rows[$index]['product_id'] = $product ? $product->id : trans('admin.not_found');
            $this->rows[$index]['unit'] = $product ? $product->unit->name : null;
            $this->rows[$index]['unit_price'] = $product ? $product->purchase_price : 0;

            $this->rows[$index]['inventoryFromBalance'] =  $invFromBalance;

            //dd( $this->rows[$index]['inventoryFromBalance']);
        }
    }
    public function fetchByName($index, $selectedProductId)
    {
        if($this->from_store_id == null && $this->to_store_id == null){
            $this->mount();
            $this->dispatch(
                'alert',
                    text: 'فضلا إختر المخزن المحول منه والمخزن المحول اليه اولا',
                    icon: 'error',
                    confirmButtonText: trans('admin.done')

            );
        } else {
            // Fetch data and update properties

            $product = Product::where('id', $selectedProductId)->first();
            $latestInventory = Inventory::where('product_id',$product->id)->latest()->first();
            //dd( $latestInventory);
            $latestProduct = SupplierInvoiceItem::where('product_id',$selectedProductId)->latest()->first();
            $purchasePrice = $latestProduct ? $latestProduct->purchase_price : $latestInventory->latest_purchase_price ;
            $invRow = $product ? Inventory::where('product_id', $product->id)
            ->where('store_id',$this->from_store_id)->latest()->first() : null;
            $invFromBalance = $invRow ? $invRow->inventory_balance : 0;

            $this->rows[$index]['product_id'] = $selectedProductId ;
            $this->rows[$index]['unit'] = $product ? $product->unit->name : null ;
            $this->rows[$index]['unit_price'] = $purchasePrice ? $purchasePrice : 0;

            $this->rows[$index]['product_name_ar'] = $product ? $product->name_ar : null;
            $this->rows[$index]['product_name_en'] = $product ? $product->name_en : null;
            $this->rows[$index]['inventoryFromBalance'] =  $invFromBalance;
            //dd($this->rows[$index]['inventoryFromBalance']);
            $this->rows[$index]['product_code'] = ProductCode::where('product_id', $this->rows[$index]['product_id'])->latest()->first()->code;
        }
    }

    public function calculateTotalPrice($index)
    {
        $this->rows[$index]['total_price'] = (float) $this->rows[$index]['qty'] * $this->rows[$index]['unit_price'];
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


    public function create() {

        $this->validate($this->rules() ,$this->messages());
         //dd($this->all());
         DB::beginTransaction();
        // try{

        $trans = new InventoryTransaction();
        $trans->trans_num = $this->getNextTransactionNum();
        $trans->trans_date_time = Carbon::parse($this->trans_date_time)->format('Y-m-d H:i:s');
        $trans->to_store_id = $this->to_store_id;
        $trans->from_store_id  = $this->from_store_id;
        $trans->created_by = Auth::user()->id;
        $trans->save();

        foreach ($this->rows as $index => $row) {
            //dd($toStore);
            $fromStoreRow = Inventory::where('product_id', $row['product_id'])
            ->where('store_id',$this->from_store_id)->latest()->first();
            $qtyInFromStore = $fromStoreRow->inventory_balance;
            //dd( $qtyInFromStore );


            $toStoreRow = Inventory::where('product_id', $row['product_id'])
            ->where('store_id',$this->to_store_id)->latest()->first();
            $qtyInToStore = $toStoreRow ? $toStoreRow->inventory_balance : 0;
            $qtyInFromStore = $fromStoreRow->inventory_balance;
            //dd( $qtyInFromStore );

            $invTrans = new InventoryTransaction();

            $invTransItem  = new InventoryTransactionItem();
            $invTransItem->inventory_transaction_id = $trans->id;
            $invTransItem->product_id = $row['product_id'];
            $invTransItem->unit_price = $row['unit_price'];
            $invTransItem->total_price = $row['unit_price'] * $row['qty'];
            $invTransItem->qty = $row['qty'];
            $invTransItem->approval ='pending';
            $invTransItem->from_branch_new_balance = $qtyInFromStore - $row['qty'];
            $invTransItem->to_branch_new_balance = $qtyInToStore ; // other branch did not approve  yet
            $invTransItem->unit = $row['unit'];
            $invTransItem->product_code = $row['product_code'];
            $invTransItem->product_name_ar = $row['product_name_ar'];
            $invTransItem->product_name_en = $row['product_name_en'];
            $invTransItem->save();

                //create new one
                $inv = new Inventory();
                $inv->initial_balance = $fromStoreRow->initial_balance ;
                $inv->inventory_balance =  $qtyInFromStore - $row['qty'];
                $inv->in_qty = 0;
                $inv->out_qty = $row['qty'];
                $inv->current_financial_year = date("Y");
                $inv->is_active = 1;
                $inv->branch_id = Store::where('id',$this->from_store_id)->first()->branch->id;
                $inv->store_id = $this->from_store_id;
                $inv->product_id = $row['product_id'];
                $inv->created_by = Auth::user()->id;
                $inv->notes = 'تحويل مخزني';
                $inv->inventorable_id = $trans ->id;
                $inv->inventorable_type = 'App\Models\InventoryTransaction';
                $inv->save();

                $product = Product::where('id',$inv->product_id)->first();
                $code = ProductCode::where('product_id',$product->id)->latest()->first()->code;
                $branch_id =  $inv->branch_id;
                if($product->alert_main_branc !== null && $product->alert_main_branch >= $inv->current_balance) {
                    event(new CheckInventoryCount($product,$branch_id,$code));
                }







        }

        $users= User::where('roles_name','سوبر-ادمن')->orWhere('branch_id',$this->to_store_id)->get();
        //dd($users);

        Notification::send($users, new NewStoreTransaction($trans));

        $this->clearInputs();
        $this->reset(['product_code','qty','product_name_ar','unit_price','total_price']);



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
        return view('livewire.stores-transactions.add-store-transaction');
    }
}

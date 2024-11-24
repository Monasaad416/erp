<?php

namespace App\Livewire\CustomerDebitNote;

use Alert;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Treasury;
use App\Models\Inventory;
use App\Models\ProductCode;
use App\Models\Transaction;
use App\Models\TreasuryShift;
use App\Models\CustomerReturn;
use App\Models\CustomerInvoice;
use App\Models\CustomerDebitNote;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerInvoiceItem;

use Illuminate\Support\Facades\Auth;
use App\Models\CustomerDebitNoteItem;
use App\Events\CustomerNewDebitNoteEvent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddDebitNote extends Component
{
    public $products=[] ,$invoice,$debitNote,$settings,$serial_num,$validationMessages,$rows=[],$customers,$units,$product,$customer_inv_num,$customer_inv_date_time, $product_id,$product_name_ar,$product_name_en, $product_code, $unit,$discount_value=0,$taxes ,$sale_price,$batch_num,$qty='',
    $discount_percentage,$invoice_discount_value=0,$price,$code_type,$invoice_products=[],$payment_type='cash',$payment_method,$status,$customerinv_num,$customerinv_date_time,$is_approved,$is_pending=0,$notes,$customer_phone,$customer_name,$inventory_balance,$total_without_tax,
    $tax=0,$total_with_tax,$finalItemPrice=0,$balance,$total_commission_rate,$fraction,$branch_id,$totalPrices=0,$totalTaxes=0,$totalPricesTaxes=0;

    public function mount($inv_num = null)
    {
        $this->settings= Setting::findOrFail(1);
        $this->customer_inv_num = $inv_num;

        $this->invoice = CustomerInvoice::where('customer_inv_num',$this->customer_inv_num)->first();

        $this->customer_inv_date_time = now()->format('Y-m-d\TH:i');
        for($i=0; $i < 10; $i++){
            $this->addRow($i);
        }

        $this->dispatch('newRowAdded');
        $this->dispatch('load');

        $this->products = Product::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','unit_id','sale_price')->where('is_active',1)->get();

        if(Auth::user()->roles_name !== 'سوبر-ادمن') {
            $this->branch_id = Auth::user()->branch_id;
        } else {
            $this->branch_id = $this->invoice->branch_id ?? null;
        }
        //dd($this->branch_id);
        $this->serial_num = $this->getNextDebitNoteSerialNum();
        //dd($this->getNextRetutnSerialNum());

    }
    public function clearInputs ()
    {
        $this->product_code = "";
        $this->qty = "";
        $this->product_name_ar = "";
        $this->product_id = "";
        $this->product_name_en = "";
        $this->discount_value = "";
        $this->discount_percentage = "";
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
        $this->validate([
            'rows.' . $index . '.product_code' => 'required|string|max:100|exists:product_codes,code',
        ]);

        // Retrieve the product name based on the product code
        $productCode = ProductCode::where('code', $this->rows[$index]['product_code'])->first();


        //dd($productCode);
        $product = Product::where('id', $productCode->product_id)->first();
        $vat = $product->taxes == 1 ? Setting::where('id',1)->first()->vat : 0 ;

        if (Auth::user()->roles_name == 'سوبر-ادمن') {
            $inv = Inventory::where('product_id',$product->id)->where('branch_id',$this->branch_id)->latest()->first();
            $this->balance = $inv ? $inv->inventory_balance : 0;
        } else {
            $inv = Inventory::where('product_id',$product->id)->where('branch_id',Auth::user()->branch_id)->latest()->first();
            $this->balance = $inv ? $inv->inventory_balance : 0;
        }

        $this->rows[$index]['product_id'] = $product ? $product->id : trans('admin.not_found');
        $this->rows[$index]['product_name_ar'] = $product ? $product->name_ar : null;
        $this->rows[$index]['product_name_en'] = $product ? $product->name_en : null;
        $this->rows[$index]['product_id'] = $product ? $product->id : trans('admin.not_found');
        $this->rows[$index]['qty'] = 1;
        $this->rows[$index]['unit'] = $product ? $product->unit->name : null;
        $this->rows[$index]['sale_price'] = $product ? $product->sale_price : null;
        $this->rows[$index]['inventory_balance'] = $this->balance ? $this->balance : 0;
        $this->rows[$index]['fraction'] = $product->fraction == 1 ? 1 : 0;
        $this->rows[$index]['total_without_tax'] = sprintf("%.2f",$this->rows[$index]['qty'] * $this->rows[$index]['sale_price']);
        $this->rows[$index]['tax'] =  sprintf("%.2f",$vat * $this->rows[$index]['sale_price']);
        $this->rows[$index]['total_with_tax'] = sprintf("%.2f",($this->rows[$index]['qty'] * $this->rows[$index]['sale_price'] * (1+ $vat)));
        $this->rows[$index]['total_commission_rate']  = $product->commission ?  sprintf("%.2f",$product->commission->commission_rate * $this->rows[$index]['sale_price'] * $this->rows[$index]['qty'] /100) : 0;
        $this->getTotals();
    }
    public function fetchByName($index, $selectedProductId )
    {

        // Fetch data and update properties
        //dd('dd');
        $product = Product::where('id', $selectedProductId)->first();
       // dd($product->commission->commission_rate);
        $vat = $product->taxes == 1 ? Setting::where('id',1)->first()->vat : 0 ;
        if (Auth::user()->roles_name == 'سوبر-ادمن') {
            $inv = Inventory::where('product_id',$product->id)->where('branch_id',$this->branch_id)->latest()->first();
            $this->balance = $inv ? $inv->inventory_balance : 0;
        } else {
            $inv = Inventory::where('product_id',$product->id)->where('branch_id',Auth::user()->branch_id)->latest()->first();
            $this->balance = $inv ? $inv->inventory_balance : 0;
        }


        $this->rows[$index]['product_id'] = $product ? $product->id : trans('admin.not_found');
        $this->rows[$index]['unit'] = $product ? $product->unit->name : null;
        $this->rows[$index]['qty'] = 1;
        $this->rows[$index]['sale_price'] = $product ? $product->sale_price : null;
        $this->rows[$index]['product_name_ar'] = $product->name_ar;
        $this->rows[$index]['inventory_balance'] = $this->balance;
        $this->rows[$index]['product_code'] = ProductCode::where('product_id', $selectedProductId)->latest()->first()->code;
        $this->rows[$index]['fraction'] = $product->fraction == 1 ? 1 : 0;
        $this->rows[$index]['total_without_tax'] = sprintf("%.2f",$this->rows[$index]['qty'] * $this->rows[$index]['sale_price']);
        $this->rows[$index]['tax'] =  sprintf("%.2f",$vat * $this->rows[$index]['sale_price']);
        $this->rows[$index]['total_with_tax'] = sprintf("%.2f",($this->rows[$index]['qty'] * $this->rows[$index]['sale_price'] * (1+ $vat)));
        $this->rows[$index]['total_commission_rate']  = $product->commission ? sprintf("%.2f", $product->commission->commission_rate * $this->rows[$index]['sale_price'] * $this->rows[$index]['qty'] /100) : 0;
       $this->getTotals();
    }
    public function getPrices($index)
    {
        if ($this->rows[$index]['qty'] !== null) {
            $product = Product::where('id', $this->rows[$index]['product_id'])->first();
            //dd($product);
             if (Auth::user()->roles_name == 'سوبر-ادمن') {
            $inv = Inventory::where('product_id',$product->id)->where('branch_id',$this->branch_id)->latest()->first();
            $this->balance = $inv ? $inv->inventory_balance : 0;
            } else {
                $inv = Inventory::where('product_id',$product->id)->where('branch_id',Auth::user()->branch_id)->latest()->first();
                $this->balance = $inv ? $inv->inventory_balance : 0;
            }
            if($product->taxes == 1) {
                $this->rows[$index]['total_without_tax'] = sprintf("%.2f", $this->rows[$index]['sale_price'] *  $this->rows[$index]['qty']);
                $this->rows[$index]['tax'] =sprintf("%.2f", ( $this->rows[$index]['sale_price'] *  $this->rows[$index]['qty']) * 0.15);
                $this->rows[$index]['total_with_tax']  = sprintf("%.2f",$this->rows[$index]['total_without_tax'] + $this->rows[$index]['qty']);
                $this->rows[$index]['total_commission_rate']  = $product->commission ? sprintf("%.2f",$product->commission->commission_rate * $this->rows[$index]['sale_price'] * $this->rows[$index]['qty'] /100) : 0 ;

            } else {
                $this->rows[$index]['total_without_tax'] =  sprintf("%.2f",$this->rows[$index]['sale_price'] *  $this->rows[$index]['qty']);
                $this->rows[$index]['tax'] = 0 ;
                $this->rows[$index]['total_with_tax']  =  sprintf("%.2f",$this->rows[$index]['sale_price'] *  $this->rows[$index]['qty']);
                $this->rows[$index]['total_commission_rate']  = $product->commission ? sprintf("%.2f",$product->commission->commission_rate * $this->rows[$index]['sale_price'] * $this->rows[$index]['qty'] /100 ): 0;
            }


            $this->getTotals();
        }


    }
    public function getTotals()
    {
        $this->totalPrices = 0;
        $this->totalTaxes = 0;


        foreach($this->rows as $row) {
            //dd($row['qty']);
            if ($row['qty'] !== null) {
                $product = Product::where('id', $row['product_id'])->first();
               // dd($product);
                if($product) {
                    if($product->taxes == 1){
                        $this->totalTaxes +=  sprintf("%.2f",$row['sale_price'] *  $row['qty'] * 0.15);
                    } else {
                            $this->totalTaxes += 0;
                    }
                    $this->totalPrices +=sprintf("%.2f", $row['sale_price'] *  $row['qty']);
                    $this->totalPricesTaxes = sprintf("%.2f",$this->totalPrices + $this->totalTaxes);
                }
            }
        }
    }
    public function focusNextRowInput($event, $index)
    {
        if ($index === count($this->rows) - 1)
        {

            $this->addRow();
            $this->dispatch('newRowAdded');
            $this->dispatch('load');
        }

        $nextIndex = $index + 1;
        $nextInputId = "input-" . $nextIndex;

        $this->dispatch('focus-input', ['inputId' => $nextInputId]);
    }
    public function addRow()
    {

        $this->rows[] = [
            'product_code' => '',
            'qty' => 0,
            'product_name_ar' => '',
            // 'product_name_en' => '',
            'product_id' => '',
            'inventory_balance'=> 0,
            'unit' => '',
            'purchase_price' => 0,
            'sale_price' => 0,
            'total_without_tax'=> 0,
            'tax'=> 0,
            'total_with_tax' => 0,
            'wholesale_inc_vat' => 0,
            'batch_num' => '',
            'taxes' => 0,
            'unit_total' => 0,
            'total_commission_rate' => 0,
            'fraction'=> 0,

        ];
         $this->dispatch('initialize-select2', ['index' => count($this->rows) - 1]);

        //     $this->dispatch('refreshJS');

    }
    public function removeItem($index)
    {
        unset($this->rows[$index -1]);
    }

    public function rules()
    {
        $rules = [
            'customer_phone' => 'nullable',
            'rows' => 'nullable|array|min:1',
            'branch_id' => 'required',
            'customer_inv_num' =>  'required',
            'payment_method' => 'required',
        ];



        foreach ($this->rows as $index => $row) {
            if($row['product_code'] != "") {

                $rules['rows.' . $index . '.product_code'] = [
                    'required',
                    'string',
                    'max:100',
                    'exists:product_codes,code',

                ];
                // $this->invoice = CustomerInvoice::where('customer_inv_num',$this->customer_inv_num)->first();
                $rules['rows.' . $index . '.qty'] = [
                    'required',
                    'numeric',

                ];
                $rules['rows.' . $index . '.discount_value'] = 'nullable|numeric';
                $rules['rows.' . $index . '.discount_percentage'] = 'nullable|numeric';
                $rules['rows.' . $index . '.batch_num'] = 'nullable|string';
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'payment_type.required' => trans('validation.payment_type_required'),
            'customer_phone.required' => 'رقم جوال العميل مطلوب',
            'branch_id.required' => 'إختر الفرع',
            'customerinv_date_time.required' => trans('validation.customerinv_date_time_required'),
            'payment_method' => 'إختر وسيلة الدفع',
            'status.required' => trans('validation.status_required'),
            'rows.*.product_code.required' => trans('validation.product_code_required'),
            'rows.*.product_code.string' => trans('validation.product_code_string'),
            'rows.*.product_code.max' => trans('validation.product_code_max'),
            'rows.*.product_code.exists' => trans('validation.product_code_exists'),
            'rows.*.discount_percentage.numeric' => trans('validation.discount_percentage_numeric'),
            'rows.*.discount_value.numeric' => trans('validation.discount_value_numeric'),
            'rows.*.qty.required' => trans('validation.qty_required'),
            'rows.*.qty.numeric' => trans('validation.qty_numeric'),
            'rows.*.qty.max' => 'الكمية  المطلوبة اقل من رصيد المخزن',
        ];
    }

    public function getNextDebitNoteSerialNum()
    {
        $currentDebitNoteNumber = CustomerDebitNote::where('branch_id', $this->branch_id)
        ->select(DB::raw('MAX(CAST(SUBSTRING(serial_num, -7) AS UNSIGNED)) AS max_serial_number'))
        ->value('max_serial_number');


        if ($currentDebitNoteNumber) {
            $serialNumber = $currentDebitNoteNumber + 1;
        } else {
            $serialNumber = 1;
        }

        $branchIdWithLeadingZeros = str_pad($this->branch_id, 1, '0', STR_PAD_LEFT);
        $serialNumberWithLeadingZeros = str_pad($serialNumber, 7, '0', STR_PAD_LEFT);
        $this->serial_num = $branchIdWithLeadingZeros. '-'. $serialNumberWithLeadingZeros;

        return $this->serial_num;

    }

    public function addDebitNote()
    {
        //dd($this->all());
        $this->validate($this->rules() ,$this->messages());

        // try{
                DB::beginTransaction();

                $this->invoice = CustomerInvoice::withTrashed()->where('customer_inv_num',$this->customer_inv_num)->first();
                //dd($this->invoice);
                $treasury = Treasury::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('branch_id',Auth::user()->branch_id)->first();

                $type="CustomerInvoice";

                if($this->customer_inv_num){
                    $this->debitNote = new CustomerDebitNote();
                    $this->debitNote->serial_num = $this->getNextDebitNoteSerialNum();
                    $this->debitNote->branch_id =$this->branch_id;
                    $this->debitNote->customer_invoice_id = $this->invoice->id;
                    $this->debitNote->created_by = Auth::user()->id;
                    $this->debitNote->type = 'debit_note';
                    $this->debitNote->payment_method = $this->payment_method;
                    $this->debitNote->save();

                    $totalWithoutTax = 0;
                    $totalTax = 0;

                    $totalDebitNoteWithTax = 0;
                    $totalDebitNoteWithoutTax = 0;
                    $totalDebitNoteTax = 0;

                    foreach ($this->rows as $index => $row) {
                        if($row['product_code'] != "")  {
                            $settings = Setting::findOrFail(1);
                            $product = Product::where('id',$row['product_id'])->first();
                            $productCode = ProductCode::where('product_id',$product->id)->latest()->first()->code;
                            if($product->taxes ==1) {
                                $tax = $settings->vat * $row['sale_price'] * $row['qty'];
                            } else {
                                $tax = 0;
                            }

                            $price = $row['sale_price'] * $row['qty'];

                            $totalPrice = $price + $tax;
                            $totalWithoutTax += $price;
                            $totalTax += $tax;




                            // $item = CustomerInvoiceItem::where('customer_invoice_id',$this->invoice->id)->where('product_id',$row['product_id'])->first();

                            $invoiceItemDebitNote = new CustomerDebitNoteItem();
                            $invoiceItemDebitNote->product_id = $row['product_id'] ;
                            $invoiceItemDebitNote->product_name_ar = $row['product_name_ar'];
                            $invoiceItemDebitNote->product_name_en = $row['product_name_en'] ?? null;
                            $invoiceItemDebitNote->product_code = $row['product_code'];
                            $invoiceItemDebitNote->unit = $row['unit'];
                            $invoiceItemDebitNote->customer_debit_note_id = $this->debitNote->id;
                            $invoiceItemDebitNote->sale_price = $row['sale_price'];
                            $invoiceItemDebitNote->total_without_tax = $row['total_without_tax'];
                            $invoiceItemDebitNote->tax = $row['tax'];
                            $invoiceItemDebitNote->total_with_tax = $row['total_with_tax'];
                            $invoiceItemDebitNote->qty = $row['qty'];
                            $invoiceItemDebitNote->customer_inv_num = $this->customer_inv_num;
                            $invoiceItemDebitNote->save();

                            $totalDebitNoteWithTax += $row['total_with_tax'];
                            $totalDebitNoteWithoutTax += $row['total_without_tax'];
                            $totalDebitNoteTax += $row['tax'];

                            $inventory = Inventory::where('product_id',$row['product_id'])->where('branch_id',$this->branch_id)->latest()->first();
                            //dd($inventory );
                            $newInv = new Inventory();
                            $newInv->inventory_balance = $inventory->inventory_balance - $row['qty'];
                            $newInv->initial_balance = $inventory->initial_balance;
                            $newInv->in_qty = 0;
                            $newInv->out_qty = $row['qty'];
                            $newInv->notes = 'إضافة إشعار مدين';
                            $newInv->current_financial_year = date("Y");
                            $newInv->product_id = $row['product_id'];
                            $newInv->is_active = $inventory->is_active;
                            $newInv->branch_id = $this->branch_id;
                            $newInv->store_id = Store::where('branch_id',$this->branch_id)->first()->id;
                            $newInv->latest_purchase_price = $inventory->latest_purchase_price;
                            $newInv->latest_sale_price = $inventory->latest_sale_price;
                            $newInv->inventorable_id = $this->debitNote->id;
                            $newInv->inventorable_type = 'App\Models\CustomerDebitNote';
                            $newInv->save();
                            //dd($newInv);




                            $this->debitNote->tax = $totalDebitNoteTax;
                            $this->debitNote->total_with_tax = $totalDebitNoteWithTax;
                            $this->debitNote->total_without_tax = $totalDebitNoteWithoutTax;
                            $this->debitNote->save();

                            $customerDebitNote = $this->debitNote;
                            event(new CustomerNewDebitNoteEvent($customerDebitNote,$tax,$price,$invoiceItemDebitNote));



                        }
                    }


                    $treasury = Treasury::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('branch_id',$this->invoice->branch_id)->first();
                    $transaction = new Transaction();
                    $transaction->transaction_type_id = 7;
                    $transaction->transactionable_type="App\Models\CustomerDebitNote" ;
                    $transaction->transactionable_id= $this->debitNote->id ;
                    $transaction->account_num= $treasury->account_num ;
                    $transaction->is_account=1 ;
                    $transaction->is_approved=1;
                    $transaction->treasury_shift_id =  Auth::user()->roles_name == 'سوبر-ادمن' ?
                    TreasuryShift::where('branch_id',$this->branch_id)->latest()->first()->id:
                    TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',Auth::user()->branch_id)->latest()->first()->id;
                    $transaction->receipt_amount =  $totalDebitNoteWithTax ;
                    $transaction->deserved_account_amount=  0;
                    $transaction->branch_id = Auth::user()->roles_name == 'سوبر-ادمن' ?  $this->branch_id  : Auth::user()->branch_id;
                    $transaction->treasury_id = $treasury->id;
                    $transaction->description= " إيصال تحصيل  مبيعات  من عميل عن فاتورة بيع رقم " . $this->invoice->customer_inv_num ." - إشعار مدين رقم $this->serial_num";
                    $transaction->serial_num = getNextSerial();
                    $transaction->state = 'تحصيل';
                    $transaction->date = Carbon::now();
                    $transaction->inv_num = $this->invoice->customer_inv_num;
                    $transaction->save();


                    $treasury->current_balance =  $treasury->current_balance + $transaction->receipt_amount ;
                    $treasury->last_collection_receipt =  $transaction->serial_num ;
                    $treasury->save();


                    send_to_zatca($this->debitNote);

                    DB::commit();
                    Alert::success('تم إضافة أشعار مدين بنجاح');
                    return redirect()->route('customers.debit_notes');

                } else {

                 }
            $this->clearInputs();





    //  } catch (Exception $e) {
    //         DB::rollback();
    //         return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
    //     }
    }
    public function render()
    {
        return view('livewire.customer-debit-note.add-debit-note');
    }
}

<?php

namespace App\Livewire\CustomerInvoicesReturns;

use Alert;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Store;
use App\Models\Account;
use App\Models\Product;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Treasury;
use App\Models\Inventory;
use App\Models\ProductCode;
use App\Models\Transaction;
use App\Models\TreasuryShift;
use App\Models\CustomerReturn;
use App\Models\PosTransaction;
use App\Models\CustomerInvoice;
use App\Models\CustomerReturnItem;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerInvoiceItem;
use Illuminate\Support\Facades\Auth;
use App\Events\NewCustomerInvoiceEvent;
use App\Events\CustomerPartiallyReturnedEvent;
use App\Events\CustomerInvoicePartiallyReturnedEvent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddCustomerReturn extends Component
{
    public $products=[] ,$invoice,$invoiceReturn,$settings,$serial_num,$validationMessages,$rows=[],$customers,$units,$product,$customer_inv_num=null,$customer_inv_date_time, $product_id,$product_name_ar,$product_name_en, $product_code, $unit,$discount_value=0,$taxes ,$sale_price,$batch_num,$qty='',
    $discount_percentage,$invoice_discount_value=0,$price,$code_type,$invoice_products=[],$status,$customerinv_num,$customerinv_date_time,$is_approved,$is_pending=0,$notes,$customer_phone,$customer_name,$inventory_balance,$total_without_tax,
    $tax=0,$total_with_tax,$finalItemPrice=0,$balance,$total_commission_rate,$fraction,$branch_id,$totalPrices=0,$totalTaxes=0,$totalPricesTaxes=0;

    public function mount($inv_num)
    {
        $this->settings= Setting::findOrFail(1);

        $this->customer_inv_num = $inv_num;
        //dd($this->customer_inv_num);
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
        $this->serial_num = $this->getNextRetutnSerialNum();
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
            'customer_inv_num' => [
            'nullable',
                function ($attribute, $value, $fail) {
                    $this->invoice = CustomerInvoice::withTrashed()->where('customer_inv_num', $value)->first();
                    //dd($this->invoice);
                    if ($this->invoice && $this->invoice->trashed()) {
                        $fail('تم رد كل بنود الفاتورة ');
                    }
                    if (!$this->invoice) {
                        $fail(' لا يوجد فاتورة عميل بهذا الرقم ');
                    }
                },
            ],
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
                    function ($attribute, $value, $fail) use ($index) {
                        if($this->customer_inv_num) {
                            $this->invoice = CustomerInvoice::where('customer_inv_num', $this->customer_inv_num)->first();
                            if (!$this->invoice) {
                                $fail('لا يوجد فاتورة عميل بهذا الرقم');
                            }

                            $customerInvoiceItem = CustomerInvoiceItem::where('customer_invoice_id', $this->invoice->id)
                                ->where('product_id', $this->rows[$index]['product_id'])
                                ->first();
                                //dd($customerInvoiceItem);

                            if ($customerInvoiceItem == null ) {
                                $fail('البند الذي تم إدخالة غير موجود بالفاتورة');
                            } else {
                                $invQty = $customerInvoiceItem->qty;
                                if ($value > $invQty) {
                                    $fail('الكمية المطلوبة أقل من كمية البند بالفاتورة.');
                                }
                            }


                        }
                    },
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

    public function getNextRetutnSerialNum()
    {
        $currentReturnNumber = CustomerReturn::where('branch_id', $this->branch_id)
        ->select(DB::raw('MAX(CAST(SUBSTRING(serial_num, -7) AS UNSIGNED)) AS max_serial_number'))
        ->value('max_serial_number');

        if ($currentReturnNumber) {
            $serialNumber = $currentReturnNumber + 1;
        } else {
            $serialNumber = 1;
        }

        $branchIdWithLeadingZeros = str_pad($this->branch_id, 1, '0', STR_PAD_LEFT);
        $serialNumberWithLeadingZeros = str_pad($serialNumber, 7, '0', STR_PAD_LEFT);
        $this->serial_num = $branchIdWithLeadingZeros. '-'. $serialNumberWithLeadingZeros;

        return $this->serial_num;

    }



    public function returnItems()
    {
        //dd($this->all());
            $this->validate($this->rules() ,$this->messages());

        // try{
                DB::beginTransaction();

                $treasury = Treasury::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('branch_id',Auth::user()->branch_id)->first();

                if($this->customer_inv_num){
                    $this->invoice = CustomerInvoice::where('customer_inv_num',$this->customer_inv_num)->first();

                    $totalWithoutTax = 0;
                    $totalTax = 0;

                    $totalReturnsWithTax = 0;
                    $totalReturnsWithoutTax = 0;
                    $totalReturnsTax = 0;

                    $this->invoiceReturn = new CustomerReturn();
                    $this->invoiceReturn->serial_num = $this->getNextRetutnSerialNum();
                    $this->invoiceReturn->branch_id =$this->branch_id;
                    $this->invoiceReturn->customer_invoice_id = $this->invoice->id;
                    $this->invoiceReturn->created_by = Auth::user()->id;
                    $this->invoiceReturn->type = 'credit_note';
                    $this->invoiceReturn->payment_method = 'cash';
                    $this->invoiceReturn->save();




                    foreach ($this->rows as $index => $row) {
                        if($row['product_code'] != "")  {
                            $settings = Setting::findOrFail(1);
                            $product = Product::where('id',$row['product_id'])->first();
                            if($product->taxes ==1) {
                                $tax = $settings->vat * $row['sale_price'] * $row['qty'];
                            } else {
                                $tax = 0;
                            }

                            $price = $row['sale_price'] * $row['qty'];

                            $totalReturnPrice = $price + $tax;
                            $totalWithoutTax += $price;
                            $totalTax += $tax;

                            $item = CustomerInvoiceItem::where('customer_invoice_id',$this->invoice->id)->where('product_id',$row['product_id'])->first();

                            $inventory = Inventory::where('product_id',$row['product_id'])->where('branch_id',$this->branch_id)->latest()->first();
                            //dd($inventory );
                            $newInv = new Inventory();
                            $newInv->inventory_balance = $inventory->inventory_balance + $row['qty'];
                            $newInv->initial_balance = $inventory->initial_balance;
                            $newInv->in_qty = $row['qty'];
                            $newInv->out_qty = 0;
                            $newInv->notes = 'رد  بند من فاتورة عميل';
                            $newInv->current_financial_year = date("Y");
                            $newInv->product_id = $row['product_id'];
                            $newInv->is_active = $inventory->is_active;
                            $newInv->branch_id = $this->branch_id;
                            $newInv->store_id = Store::where('branch_id',$this->branch_id)->first()->id;
                            $newInv->latest_purchase_price = $inventory->latest_purchase_price;
                            $newInv->latest_sale_price = $inventory->latest_sale_price;
                            $newInv->inventorable_id = $item->id;
                            $newInv->inventorable_type = 'App\Models\CustomerReturn';
                            $newInv->save();
                            //dd($newInv);

                            $this->invoice->return_status = 11; // item returned in customers invoices table
                            $this->invoice->save();

                            // $item->return_qty = $row['qty'];

                            // // $item->tax = ($row['qty - $this->qty) * $item->sale_price * $settings->vat;
                            // $item->total_without_tax = ($item->qty - $row['qty']) * $item->sale_price;
                            // $item->total_with_tax = (($item->qty - $row['qty']) * $item->sale_price) * (1+ $settings->vat);
                            // // $item->inventory_balance = $this->item->inventory_balance - $this->qty;


                            // $item->return_status = 2;// item returned partially in customers invoices items table

                            // $item->save();

                            $invoiceItemReturn = new CustomerReturnItem();
                            $invoiceItemReturn->product_id = $item->product_id ;
                            $invoiceItemReturn->product_name_ar =$item->product_name_ar;
                            $invoiceItemReturn->product_name_en =$item->product_name_en ?? null;
                            $invoiceItemReturn->product_code =$item->product_code;
                            $invoiceItemReturn->unit =$item->unit;
                            $invoiceItemReturn->customer_return_id = $this->invoiceReturn->id;
                            $invoiceItemReturn->sale_price =$item->sale_price;
                            $invoiceItemReturn->total_without_tax =$item->total_without_tax;
                            $invoiceItemReturn->tax =$item->tax;
                            $invoiceItemReturn->total_with_tax =$item->total_with_tax;
                            $invoiceItemReturn->return_qty = $row['qty'];
                            $invoiceItemReturn->return_status = 3;
                            $invoiceItemReturn->customer_inv_num = $this->customer_inv_num;
                            $invoiceItemReturn->save();

                            //dd($invoiceItemReturn);


                            $totalReturnsWithTax += $invoiceItemReturn->total_with_tax;
                            $totalReturnsTax += $invoiceItemReturn->tax;
                            $totalReturnsWithoutTax += $invoiceItemReturn->total_without_tax;


                            if($item->qty == $row['qty']) {
                                $item->return_status = 1 ;
                                $item->save();
                            } else {
                                $item->return_status = 2;// item returned partially in customers invoices items table
                                $item->save();
                            }

                            $this->invoiceReturn->tax = $totalReturnsTax;
                            $this->invoiceReturn->total_with_tax = $totalReturnsWithTax;
                            $this->invoiceReturn->total_without_tax = $totalReturnsWithoutTax;
                            $this->invoiceReturn->save();

                            $invoiceReturn = $this->invoiceReturn;

                            event(new CustomerInvoicePartiallyReturnedEvent($invoiceReturn, $tax ,$price,$item ));

                        }
                    }

                    $transaction = new Transaction();
                    $transaction->transaction_type_id = 7;
                    $transaction->transactionable_type="App\Models\CustomerReturn" ;
                    $transaction->transactionable_id= $invoiceReturn->id ;
                    $transaction->account_num= $treasury->account_num ;
                    $transaction->is_account=1 ;
                    $transaction->is_approved=1;
                    $transaction->treasury_shift_id =  Auth::user()->roles_name == 'سوبر-ادمن' ?
                    TreasuryShift::where('branch_id',$this->branch_id)->latest()->first()->id:
                    TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',Auth::user()->branch_id)->latest()->first()->id;
                    $transaction->receipt_amount =  $totalReturnsWithTax ;
                    $transaction->deserved_account_amount=  0;
                    $transaction->branch_id = Auth::user()->roles_name == 'سوبر-ادمن' ?  $this->branch_id  : Auth::user()->branch_id;
                    $transaction->treasury_id = $treasury->id;
                    $transaction->description= "إيصال دفع مردودات  مبيعات  لعميل عن فاتورة بيع رقم " . $this->invoice->customer_inv_num ."  - إشعار دائن رقم $this->serial_num";
                    $transaction->serial_num = getNextSerial();
                    $transaction->state = 'صرف';
                    $transaction->date = Carbon::now();
                    $transaction->inv_num = $this->invoice->customer_inv_num;
                    $transaction->save();



                    send_to_zatca($this->invoiceReturn);

                    DB::commit();
                    $this->clearInputs();
                    Alert::success('تم رد البنود و إضافة إشعار دائن بنجاح');
                    return redirect()->route('customers.returns');

                } else {
                    //مردود غير مرتبط بفاتورة

                    $invoiceReturn = new CustomerReturn();
                    $invoiceReturn->serial_num = $this->getNextRetutnSerialNum();
                    $invoiceReturn->branch_id =$this->branch_id;
                    $invoiceReturn->customer_invoice_id = null;
                    $invoiceReturn->created_by = Auth::user()->id;
                    $invoiceReturn->save();

                    $totalWithoutTax = 0;
                    $totalTax = 0;
                    foreach ($this->rows as $index => $row) {
                        if($row['product_code'] != "")  {
                            $settings = Setting::findOrFail(1);
                            $product = Product::where('id',$row['product_id'])->first();
                            if($product->taxes ==1) {
                                $tax = $settings->vat * $row['qty'] * $row['sale_price'];
                            } else {
                                $tax = 0;
                            }

                            $price = $row['qty'] * $row['sale_price'];

                            $item = Product::where('id',$row['product_id'])->first();
                            $productCode = ProductCode::where('id',$item->id)->latest()->first()->code;

                            $totalReturnPrice = $price + $tax;
                            $totalWithoutTax += $price;
                            $totalTax +=  $tax;


                            $invoiceItemReturn = new CustomerReturnItem();
                            $invoiceItemReturn->product_id = $item->id ;
                            $invoiceItemReturn->product_name_ar = $item->name_ar;
                            $invoiceItemReturn->product_name_en = $item->name_en ?? null;
                            $invoiceItemReturn->product_code = $productCode;
                            $invoiceItemReturn->unit = $item->unit->name;
                            $invoiceItemReturn->customer_return_id = $invoiceReturn->id;
                            $invoiceItemReturn->sale_price = $item->sale_price;
                            $invoiceItemReturn->total_without_tax = $price;
                            $invoiceItemReturn->tax =$tax;
                            $invoiceItemReturn->total_with_tax =$tax + $price;
                            $invoiceItemReturn->return_qty = $row['qty'];
                            $invoiceItemReturn->return_status = 3;
                            $invoiceItemReturn->save();

                            $inventory = Inventory::where('product_id',$row['product_id'])->where('branch_id',$this->branch_id)->latest()->first();
                            //dd($inventory );
                            $newInv = new Inventory();
                            $newInv->inventory_balance = $inventory->inventory_balance + $row['qty'];
                            $newInv->initial_balance = $inventory->initial_balance;
                            $newInv->in_qty = $row['qty'];
                            $newInv->out_qty = 0;
                            $newInv->notes = 'رد  بند من عميل';
                            $newInv->current_financial_year = date("Y");
                            $newInv->product_id = $row['product_id'];
                            $newInv->is_active = $inventory->is_active;
                            $newInv->branch_id = $this->branch_id;
                            $newInv->store_id = Store::where('branch_id',$this->branch_id)->first()->id;
                            $newInv->latest_purchase_price = $inventory->latest_purchase_price;
                            $newInv->latest_sale_price = $inventory->latest_sale_price;
                            $newInv->inventorable_id = $product->id;
                            $newInv->inventorable_type = 'App\Models\CustomerReturn';
                            $newInv->save();
                            //dd($newInv);

                            event(new CustomerPartiallyReturnedEvent( $row['qty'],$tax,$price,$product,$this->branch_id));

                        }
                    }

                    $transaction = new Transaction();
                    $transaction->transaction_type_id = 7;
                    $transaction->transactionable_type="App\Models\CustomerReturn" ;
                    $transaction->transactionable_id= $invoiceReturn->id ;
                    $transaction->account_num = $treasury->account_num ;
                    $transaction->is_account=1 ;
                    $transaction->is_approved=1;
                    $transaction->treasury_shift_id =  Auth::user()->roles_name == 'سوبر-ادمن' ?
                    TreasuryShift::where('branch_id',$this->branch_id)->latest()->first()->id:
                    TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',Auth::user()->branch_id)->latest()->first()->id;
                    $transaction->receipt_amount = $totalWithoutTax + $totalTax;
                    $transaction->deserved_account_amount=  0;
                    $transaction->branch_id = $this->branch_id;
                    $transaction->treasury_id = $treasury->id;
                    $transaction->description= "  إيصال دفع مردودات مبيعات لعميل - لايوجد فاتورة " ;
                    $transaction->serial_num = getNextSerial();
                    $transaction->state = 'صرف';
                    $transaction->date = Carbon::now();
                    $transaction->inv_num = null;
                    $transaction->save();

                    DB::commit();
                    $this->clearInputs();
                    Alert::success('تم رد البنود بنجاح');
                    return redirect()->route('customers.returns');
                 }






    //  } catch (Exception $e) {
    //         DB::rollback();
    //         return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
    //     }
    }

    public function render()
    {
        return view('livewire.customer-invoices-returns.add-customer-return');
    }
}


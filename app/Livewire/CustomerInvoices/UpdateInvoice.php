<?php

namespace App\Livewire\CustomerInvoices;

use Alert;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Treasury;
use App\Models\Inventory;
use App\Models\ProductCode;
use App\Models\Transaction;
use App\Models\TreasuryShift;
use App\Models\CustomerInvoice;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerInvoiceItem;
use Illuminate\Support\Facades\Auth;
use App\Events\NewCustomerInvoiceEvent;
use App\Events\NewTreasuryCollectionTransactionEvent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UpdateInvoice extends Component
{
    public $customers,$units,$product, $product_id,$product_name_ar,$product_name_en,$purchase_price,$wholesale_inc_vat,
    $qty='',$price,$rows=[],$invoice_products=[],$invoice,
    $discount_percentage = 0,$discount_value=0,$taxes,$product_code,$customer_id,$customer_inv_date_time,$customer_inv_num
    ,$payment_type,$payment_method,$notes,$is_pending=0,$unit,$customer_invoice_id,$balance,$branch_id,$totalPrices=0,$totalTaxes,$totalPricesTaxes=0,
    $oldTotalPrices,$oldTotalTaxes,$oldTotalPricesTaxes=0,$type;


    public $listeners = ['refreshData' =>'$refresh'];

    public function mount($invoice,$type)
    {
        $this->invoice = $invoice;
        $this->type = $type;
        //dd($this->type);
        $this->invoice_products = CustomerInvoiceItem::withTrashed()->where('customer_invoice_id', $this->invoice->id)->get();

        $this->is_pending = $this->invoice->is_pending;
        $this->branch_id = $this->invoice->branch_id;
        $this->customer_inv_num = $this->invoice->customer_inv_num;
        $this->customer_id = $this->invoice->customer_id;
        $this->customer_inv_date_time = Carbon::parse($this->invoice->customer_inv_date_time)->format('Y-m-d H:i:s');
        $this->payment_type = $this->invoice->payment_type;
        $this->payment_method = $this->invoice->payment_method;
        $this->discount_percentage = $this->invoice->discount_percentage;
        // $this->discount_value = $this->invoice->discount_value;
        // $this->addRow(0);
        $this->dispatch('newRowAdded');
         $this->getTotals();





        //dd($this->rows);

        // Set other properties if needed
        // ...

        // Fill the inputs from the mounted data

        $this->addRow();

        $this->oldTotalPrices =0;
        $this->oldTotalTaxes =0;
        $this->oldTotalPricesTaxes =0;


        //get total prices
        if ($this->invoice_products->count() > 0) {
            foreach($this->invoice_products as $item)
            {
                $product = Product::where('id', $item->product_id)->first();
                // dd($product);
                if($product) {
                    if($product->taxes == 1){
                        $this->oldTotalTaxes +=  sprintf("%.2f",$item->sale_price *  $item->qty * 0.15);
                    } else {
                            $this->oldTotalTaxes += 0;
                    }
                    $this->oldTotalPrices += sprintf("%.2f", $item->sale_price *  $item->qty);
                    $this->oldTotalPricesTaxes = sprintf("%.2f",$this->oldTotalPrices + $this->oldTotalTaxes);
               }
            }
        }

        $this->totalPrices = $this->oldTotalPrices;
        $this->totalTaxes = $this->oldTotalTaxes;
        $this->totalPricesTaxes = $this->oldTotalPricesTaxes;
    }


public function fillInputs()
{
    foreach ($this->rows as $index => $row) {
        $this->invoice_products[$index]['product_code'] = $row['product_code'];
        $this->invoice_products[$index]['qty'] = $row['qty'];
        $this->invoice_products[$index]['product_name_ar'] = $row['product_name_ar'];
        $this->invoice_products[$index]['product_name_en'] = $row['product_name_en'];
        $this->invoice_products[$index]['unit'] = $row['unit'];
        $this->invoice_products[$index]['purchase_price'] = $row['purchase_price'];
        $this->invoice_products[$index]['wholesale_inc_vat'] = $row['wholesale_inc_vat'];
        $this->invoice_products[$index]['item_discount_percentage'] = $row['item_discount_percentage'];
        $this->invoice_products[$index]['discount_value'] = $row['discount_value'];
    }


}
    public function clearInputs ()
    {
        $this->product_code = "";
        $this->qty = "";
        $this->product_name_ar = "";
        $this->product_name_en = "";
        $this->purchase_price = "";
        $this->wholesale_inc_vat = "";
        $this->product_id = "";
        $this->discount_value = "";
        $this->discount_percentage = "";
        $this->taxes = "";
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
        $this->rows[$index]['total_without_tax'] = $this->rows[$index]['qty'] * $this->rows[$index]['sale_price'];
        $this->rows[$index]['tax'] =  $vat * $this->rows[$index]['sale_price'];
        $this->rows[$index]['total_with_tax'] = number_format(($this->rows[$index]['qty'] * $this->rows[$index]['sale_price'] * (1+ $vat)),2);
        $this->rows[$index]['total_commission_rate']  = $product->commission ?  $product->commission->commission_rate * $this->rows[$index]['sale_price'] * $this->rows[$index]['qty'] /100 : 0;
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
        $this->rows[$index]['total_without_tax'] = $this->rows[$index]['qty'] * $this->rows[$index]['sale_price'];
        $this->rows[$index]['tax'] =  $vat * $this->rows[$index]['sale_price'];
        $this->rows[$index]['total_with_tax'] = number_format(($this->rows[$index]['qty'] * $this->rows[$index]['sale_price'] * (1+ $vat)),2);
        $this->rows[$index]['total_commission_rate']  = $product->commission ? $product->commission->commission_rate * $this->rows[$index]['sale_price'] * $this->rows[$index]['qty'] /100 : 0;
       $this->getTotals();
    }


    public function getPrices($index)
    {
        if ($this->rows[$index]['qty'] !== null)
        {
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
                $this->rows[$index]['total_without_tax'] =  $this->rows[$index]['sale_price'] *  $this->rows[$index]['qty'];
                $this->rows[$index]['tax'] =number_format( ( $this->rows[$index]['sale_price'] *  $this->rows[$index]['qty']) * 0.15,2);
                $this->rows[$index]['total_with_tax']  = $this->rows[$index]['total_without_tax'] + $this->rows[$index]['qty'];
                $this->rows[$index]['total_commission_rate']  = $product->commission ? $product->commission->commission_rate * $this->rows[$index]['sale_price'] * $this->rows[$index]['qty'] /100 : 0 ;

            } else {
                $this->rows[$index]['total_without_tax'] =  $this->rows[$index]['sale_price'] *  $this->rows[$index]['qty'];
                $this->rows[$index]['tax'] = 0 ;
                $this->rows[$index]['total_with_tax']  =  $this->rows[$index]['sale_price'] *  $this->rows[$index]['qty'];
                $this->rows[$index]['total_commission_rate']  = $product->commission ? $product->commission->commission_rate * $this->rows[$index]['sale_price'] * $this->rows[$index]['qty'] /100 : 0;
            }


            $this->getTotals();
        }
    }


    public function getTotals()
    {
        $this->totalPrices = $this->oldTotalPrices;
        $this->totalTaxes = $this->oldTotalTaxes;
        $this->totalPricesTaxes = $this->oldTotalPricesTaxes;






        foreach($this->rows as $row) {
            if ($row['qty'] !== null) {
                $product = Product::where('id', $row['product_id'])->first();
               // dd($product);
                if($product) {
                    if($product->taxes == 1){
                        $this->totalTaxes +=  sprintf("%.2f",$row['sale_price'] *  $row['qty'] * 0.15) ;
                    } else {
                            $this->totalTaxes += 0;
                    }
                    $this->totalPrices += sprintf("%.2f",$row['sale_price'] *  $row['qty']);
                    $this->totalPricesTaxes = sprintf("%.2f",$this->totalPrices + $this->totalTaxes);
                }
            }
        }
    }

    public function rules()
    {
        return [
            'product_code' => "nullable|string|max:20|exists:products,product_code",
            'qty' => "nullable|numeric",
            // 'purchase_price' => 'nullable_if:wholesale_inc_vat,null',
            // 'wholesale_inc_vat' => 'nullable_if:purchase_price,null',
            'discount_value' =>'nullable|numeric',
            'discount_percentage' =>'nullable|numeric',
            'payment_type' => "nullable|string",
            // 'status' => 'nullable',
            'notes' =>'nullable|string',
            'is_pending' =>'nullable',

        ];
    }

    public function messages()
    {
        return [

            'product_code.required' => trans('validation.product_code_required'),
            'product_code.string' => trans('validation.product_code_string'),
            'product_code.max' => trans('validation.product_code_max'),
            'product_code.exists' => trans('validation.product_code_exists'),
            'purchase_price.required_if' => trans('validation.purchase_price_required_if'),
            'wholesale_inc_vat.required_if' => trans('validation.wholesale_inc_vat_required_if'),
            'wholesale_inc_vat.numeric' => trans('validation.wholesale_inc_vat_numeric'),
            'purchase_price.min' => trans('validation.purchase_price_min'),
            'discount_percentage.numeric' => trans('validation.discount_percentage_numeric'),
            'discount_value.numeric' => trans('validation.discount_value_numeric'),
            'qty.required' => trans('validation.qty_required'),
            'qty.numeric' => trans('validation.qty_numeric'),
            'payment_type.required' => trans('validation.payment_type_required'),
        ];
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
        // $this->clearInputs();
        $this->rows[] = [
         'product_code' => '',
            'qty' => '',
            'product_name_ar' => '',
            // 'product_name_en' => '',
            'product_id' => '',
            'unit' => '',
            'purchase_price' => '',
            'sale_price' => '',
            'wholesale_inc_vat' => '',

        ];
    }
    public function installmentsPayment()
    {
        $this->update();

        $this->invoice->payment_type  = 'by_installments';
        $this->invoice->save();
        $type = "CustomerInvoice";

        event(new NewCustomerInvoiceEvent($this->invoice,$type));//الحسابات لفواتير الاجل
        //dd('dd');
        $this->invoice->is_pending = 0;
        $this->invoice->save();

        DB::commit();
        Alert::success('تم تعديل فاتورة عميل  بنجاح');
        return redirect()->route('customers.invoices');
    }
    public function cashPayment()
    {
        $this->update();
        $this->invoice->payment_method  = 'cash';
        $this->invoice->payment_type  = 'cash';
        $this->invoice->is_pending = 0;
        $this->invoice->save();

        $invoice = CustomerInvoice::where('customer_inv_num',$this->customer_inv_num)->first();
        $treasury = Treasury::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('branch_id',Auth::user()->branch_id)->first();
        $transaction = new Transaction();
        $transaction->transaction_type_id = 9;
        $transaction->transactionable_type="App\Models\Customer" ;
        $transaction->transactionable_id= $invoice->id ;
        $transaction->account_num= $treasury->account_num ;
        $transaction->is_account=1 ;
        $transaction->is_approved=1;
        $transaction->treasury_shift_id = TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',Auth::user()->branch_id)->latest()->first()->id;
        $transaction->receipt_amount=$invoice->total_after_discount;
        $transaction->deserved_account_amount=  0;
        $transaction->branch_id = Auth::user()->roles_name == 'سوبر-ادمن' ? User::where('roles_name' , 'سوبر-ادمن')->first()->branch_id : Auth::user()->branch_id;
        $transaction->treasury_id = $treasury->id;
        $transaction->description= "إيصال تحصيل ايرادات مبيعات من عميل عن فاتورة بيع رقم $invoice->customer_inv_num ";
        $transaction->serial_num = getNextSerial();
        $transaction->state = 'تحصيل';
        $transaction->date = $invoice->customer_inv_date_time;
        $transaction->inv_num = $invoice->customer_inv_num;
        $transaction->save();

        $type="CustomerInvoice";
    //dd('ll');
        event(new NewTreasuryCollectionTransactionEvent( $transaction, $invoice ,$type));
       
        DB::commit();

        Alert::success(' تم إضافة فاتورة عميل جديدة بنجاح - الدفع كاش');
        return redirect()->route('customers.cash_pay_invoice',['inv_num' => $this->customer_inv_num]);

    }
    public function visaPayment()
    {
        $this->update();
        $this->invoice->payment_method  = 'visa';
        $this->invoice->payment_type  = 'cash';
        $this->invoice->save();
        DB::commit();

        Alert::success('تم إضافة فاتورة عميل  جديدة بنجاح - الدفع بالفيزا');
        // return redirect()->route('customers.invoices');
    }

    public function pendInvoice()
    {
        $this->update();

        // $invoice = CustomerInvoice::where('customer_inv_num',$this->customer_inv_num)->first();
        //dd($invoice);
        $this->invoice->is_pending = 1;
        $this->invoice->save();
        DB::commit();



         Alert::error('تم تعليق الفاتوره');
        return redirect()->route('customers.edit_invoice',$this->customer_inv_num);
   
    }

    public function update() {
        //dd("ddd");


        $this->validate($this->rules(),$this->messages());

        // try {

            DB::beginTransaction();
            if($this->is_pending == 1) {
                //dd($this->invoice);


                    $invTotalWithTaxesBeforeDiscount = $this->invoice->total_before_discount;
                    $invTaxs = $this->invoice->tax_value;
                    $totalCommissionRate = $this->invoice->total_commission_rate;

                    //dd($invTotalWithTaxesBeforeDiscount,$invTaxs,$totalCommissionRate);


                    foreach ($this->rows as $index => $row) {
                        if($row['product_id']) {
                            //dd("kk");
                            $product = Product::where('id', $row['product_id'] )->first();
                           // dd($product);
                            $invoiceItem = new CustomerInvoiceItem();
                            $invoiceItem->product_id = $row['product_id'];
                            $invoiceItem->product_name_ar = $row['product_name_ar'];
                            $invoiceItem->product_name_en = $row['product_name_en'] ?? null;
                            $invoiceItem->product_code = $row['product_code'];
                            $invoiceItem->unit = $row['unit'];
                            $invoiceItem->customer_invoice_id = $this->invoice->id;
                            $invoiceItem->qty = $row['qty'];
                            $invoiceItem->sale_price = $row['sale_price'];
                            $invoiceItem->total_without_tax = $row['total_without_tax'];
                            $invoiceItem->tax = $row['tax'];
                            $invoiceItem->total_with_tax = $row['total_with_tax'];
                            $invoiceItem->total_commission_rate = $row['total_commission_rate'];
                            $invoiceItem->save();

                            $this->invoice->total_before_discount = $this->invoice->total_before_discount + $row['total_with_tax'];
                            $this->invoice->tax_value = $this->invoice->tax_value + $row['tax'];
                            $this->invoice->total_commission_rate = $this->invoice->total_commission_rate + $row['total_commission_rate'];
                            $this->invoice->save();
                        }

                    }

                    //updates in customer_invoices table
                    if($this->discount_percentage > 0){
                        $this->invoice->total_after_discount = $this->invoice->total_before_discount*(1- ($this->discount_percentage/100) );
                        $this->invoice->save();
                    } else {
                            $this->invoice->total_after_discount = $this->invoice->total_before_discount;
                    }



                // Alert::success('تم إضافة بنود للفاتورة بنجاح');
                // return redirect()->route('customers.edit_invoice',['inv_num' =>$this->invoice->customer_inv_num]);


                $this->clearInputs();
            } else {
                //dd("kk");
                    // $this->invoice->is_pending = $this->is_pending ;
                    $this->invoice->notes = $this->notes ;
                    $this->invoice->payment_type = $this->payment_type ;
                    $this->invoice->customer_id = $this->customer_id ;
                    $this->invoice->customer_inv_date_time = $this->customer_inv_date_time ;
                    $this->invoice->save();

                    if($this->discount_percentage != $this->invoice->discount_percentage)
                    {
                        $this->invoice->discount_percentage = $this->discount_percentage ;
                        $this->invoice->total_after_discount = $this->invoice->total_after_discount*(1- ($this->discount_percentage/100) );
                        $this->invoice->save();
                    }

                    DB::commit();

                    Alert::success('تم تعديل الفاتورة بنجاح');
                    return redirect()->route('customers.edit_invoice',['inv_num' =>$this->invoice->customer_inv_num]);
                    // return redirect()->route('customers.pay_invoice',['inv_num' => $this->invoice->customer_inv_num]);

            }
            

    //  } catch (Exception $e) {
    //         DB::rollback();
    //         return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
    //     }






        }





       public function render()
    {
        return view('livewire.customer-invoices.update-invoice');
    }
}

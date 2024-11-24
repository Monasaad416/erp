<?php
namespace App\Livewire\CustomerInvoices;

use Alert;
use Exception;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\User;
use App\Models\Offer;
use App\Models\Account;
use App\Models\Product;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Treasury;
use App\Models\Inventory;
use App\Models\BranchOffer;
use App\Models\ProductCode;
use App\Models\Transaction;
use App\Models\TreasuryShift;
use App\Models\PosTransaction;
use App\Models\CustomerInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerInvoiceItem;
use Illuminate\Support\Facades\Auth;
use App\Events\NewCustomerInvoiceEvent;
use Illuminate\Support\Facades\Validator;
use App\Livewire\CustomerInvoices\DisplayInvoices;
use App\Events\NewTreasuryCollectionTransactionEvent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddInvoice extends Component
{
    public $products=[] ,$invoice,$settings,$validationMessages,$rows=[],$customers,$units,$product,$customer_inv_num,$customer_inv_date_time, $product_id,$product_name_ar,$product_name_en, $product_code, $unit,$discount_value=0,$taxes ,$sale_price,$batch_num,$qty='',
    $discount_percentage,$invoice_discount_value=0,$price,$code_type,$invoice_products=[],$payment_type='cash',$payment_method,$status,$customerinv_num,$customerinv_date_time,$is_approved,$is_pending=0,$notes,$customer_phone,$customer_name,$inventory_balance,$total_without_tax,
    $tax=0,$total_with_tax,$finalItemPrice=0,$balance,$total_commission_rate,$fraction,$currentTreasuryShift,$branch_id,$totalPrices=0,$totalTaxes=0,$totalPricesTaxes=0,$customer;

    public function mount()
    {
        $this->currentTreasuryShift = TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',Auth::user()->branch_id)->latest()->first();

        if($this->currentTreasuryShift  == null){
            $this->dispatch(
                'alert',
                text: 'فضلا قم بتسجيل وردية الخزينة الحالية اولا حتي تتمكن  من إضافة فاتورة المبيعات',
                icon: 'error',
                confirmButtonText: trans('admin.done')
            );
        }
        $this->settings= Setting::findOrFail(1);

        if(!$this->settings->vat) {
            $this->dispatch(
                'alert',
                text: 'فضلا املاء الحقول الخاصة بالضريبة في قسم الإعدادات اولا ثم قم بتسجيل الفاتورة',
                icon: 'error',
                confirmButtonText: trans('admin.done')
            );
        }

        $this->customer_inv_date_time = now()->format('Y-m-d\TH:i');
        for($i=0; $i < 10; $i++){
            $this->addRow($i);
        }

        $this->dispatch('newRowAdded');
        $this->dispatch('load');

        $this->products = Product::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','unit_id','sale_price')->where('is_active',1)->get();

        if(Auth::user()->roles_name !== 'سوبر-ادمن') {
            $this->branch_id = Auth::user()->branch_id;
        }
        //dd($this->branch_id);
        $this->getNextCustomerInvNum();

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

        if (!$this->branch_id) {
            $this->dispatch(
                'alert',
                text: 'فضلا إختر الفرع اولا ',
                icon: 'error',
                confirmButtonText: trans('admin.done')
            );
        }


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


        $offer  = Offer::where('product_id',$product->id)->where('from_date','<',Carbon::now() )->where('to_date','>',Carbon::now() )->latest()->first();
        //dd($offer);
        $offerPrice = 0;
        if ($offer){
            $branchesOfferIds = BranchOffer::where('offer_id',$offer->id)->pluck('branch_id')->toArray();
            //dd($branchesOfferIds);

            if(in_array($this->branch_id,$branchesOfferIds)) {
                $offerPrice = $offer->price;
               // dd($offerPrice);
            }
        }


        $this->rows[$index]['product_id'] = $product ? $product->id : trans('admin.not_found');
        $this->rows[$index]['product_name_ar'] = $product ? $product->name_ar : null;
        $this->rows[$index]['product_name_en'] = $product ? $product->name_en : null;
        $this->rows[$index]['product_id'] = $product ? $product->id : trans('admin.not_found');
        $this->rows[$index]['qty'] = 1;
        $this->rows[$index]['unit'] = $product ? $product->unit->name : 'not found';
        $this->rows[$index]['sale_price'] = $offerPrice > 0  ? $offerPrice : $product->sale_price ;
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


        if (!$this->branch_id) {
            $this->dispatch(
                'alert',
                text: 'فضلا إختر الفرع اولا ',
                icon: 'error',
                confirmButtonText: trans('admin.done')
            );
        } else {

        

            // Fetch data and update properties
            //dd('dd');
            $product = Product::where('id', $selectedProductId)->first();
            //dd($selectedProductId);
            $vat = $product->taxes == 1 ? Setting::where('id',1)->first()->vat : 0 ;
            if (Auth::user()->roles_name == 'سوبر-ادمن') {
                $inv = Inventory::where('product_id',$product->id)->where('branch_id',$this->branch_id)->latest()->first();
                $this->balance = $inv ? $inv->inventory_balance : 0;
            } else {
                $inv = Inventory::where('product_id',$product->id)->where('branch_id',Auth::user()->branch_id)->latest()->first();
                $this->balance = $inv ? $inv->inventory_balance : 0;
            }

            $offer  = Offer::where('product_id',$product->id)->where('from_date','<',Carbon::now() )->where('to_date','>',Carbon::now() )->latest()->first();
            //dd($offer);
            $offerPrice = 0;
            if ($offer){
                $branchesOfferIds = BranchOffer::where('offer_id',$offer->id)->pluck('branch_id')->toArray();
                //dd($branchesOfferIds);

                if(in_array($this->branch_id,$branchesOfferIds)) {
                    $offerPrice = $offer->price;
                // dd($offerPrice);
                }
            }
            //dd($selectedProductId);
            //dd(ProductCode::where('product_id','=', $selectedProductId)->latest()->first());


            $this->rows[$index]['product_id'] = $product ? $product->id : trans('admin.not_found');
            $this->rows[$index]['unit'] = $product ? $product->unit->name : null;
            $this->rows[$index]['qty'] = 1;
            $this->rows[$index]['sale_price'] = $offerPrice > 0 ? $offerPrice : $product->sale_price ;
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
                        $itemTax = sprintf("%.2f",$row['sale_price'] *  $row['qty'] * 0.15);
                        $this->totalTaxes += $itemTax;
                    } else {
                            $this->totalTaxes += 0;
                    }
                    $this->totalPrices += sprintf("%.2f", $row['sale_price'] *  $row['qty']);
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
            'payment_type' => 'required',
            'notes' => 'nullable|string',
            'is_pending' => 'required',
            'customer_phone' => 'nullable',
            'rows' => 'nullable|array|min:1',
        ];



        foreach ($this->rows as $index => $row) {
            if($row['product_code'] != "") {

                $rules['rows.' . $index . '.product_code'] = [
                    'required',
                    'string',
                    'max:100',
                    'exists:product_codes,code',
                ];
                $rules['rows.' . $index . '.qty'] = [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($index) {
                        $inventory_balance = $this->rows[$index]['inventory_balance'];
                        if ($value > $inventory_balance) {
                            $fail('الكمية المطلوبة غير متوفره بالمخزن');
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
            'customerinv_date_time.required' => trans('validation.customerinv_date_time_required'),
            // 'payment_type.in' => trans('validatipaddon.payment_type_in'),
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

    public function getNextCustomerInvNum()
    {


        $currentInvoiceNumber = CustomerInvoice::withTrashed()
        ->where('branch_id', $this->branch_id)
        ->select(DB::raw('MAX(CAST(SUBSTRING(customer_inv_num, -7) AS UNSIGNED)) AS max_invoice_number'))
        ->value('max_invoice_number');

        if ($currentInvoiceNumber) {
            $invoiceNumber = $currentInvoiceNumber + 1;
        } else {
            $invoiceNumber = 1;
        }

        $branchIdWithLeadingZeros = str_pad($this->branch_id, 1, '0', STR_PAD_LEFT);
        $invoiceNumberWithLeadingZeros = str_pad($invoiceNumber, 7, '0', STR_PAD_LEFT);
        $this->customer_inv_num = 'C-' . $branchIdWithLeadingZeros. '-'. $invoiceNumberWithLeadingZeros;

        return $this->customer_inv_num;

    }

    public function installmentsPayment()
    {

        if($this->customer_phone == null ) {
            $this->dispatch(
                'alert',
                text: 'بيانات العميل الزامية للدفع الاجل - فضلا ادخل بيانات العميل لتسجيلها بقاعدة البيانات',
                icon: 'error',
                confirmButtonText: trans('admin.done')
            );
        }  else {
            $this->create();

            $this->invoice->payment_type = 'by_installments';
            $this->invoice->save();

            $type = "CustomerInvoice";

            //dd($this->customer);
            event(new NewCustomerInvoiceEvent($this->invoice, $type, $this->customer));//الحسابات لفواتير الاجل

            DB::commit();
            Alert::success('تم إضافة فاتورة عميل أجلة جديدة بنجاح');
            return redirect()->route('customers.invoices');
        }


    }
    public function cashPayment()
    {
        //  DB::beginTransaction();
        $this->create();
        $this->invoice->payment_method  = 'cash';
        $this->invoice->payment_type  = 'cash';
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
        $transaction->treasury_shift_id = $this->currentTreasuryShift->id ;
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


        send_to_zatca($this->invoice);

        DB::commit();

        Alert::success(' تم إضافة فاتورة عميل جديدة بنجاح - الدفع كاش');
        return redirect()->route('customers.cash_pay_invoice',['inv_num' => $this->customer_inv_num]);

    }
    public function visaPayment()
    {
        $this->create();
        $this->invoice->payment_method  = 'visa';
        $this->invoice->payment_type  = 'cash';
        $this->invoice->save();

        send_to_zatca($this->invoice);


          DB::commit();
        Alert::success('تم إضافة فاتورة عميل  جديدة بنجاح - الدفع بالفيزا');
        // return redirect()->route('customers.invoices');
    }

    public function pendInvoice()
    {
        $this->create();
        DB::commit();
        $invoice = CustomerInvoice::where('customer_inv_num',$this->customer_inv_num)->first();
        $invoice->is_pending = 1;
        $invoice->save();



         Alert::error('  تم تعليق الفاتوره');
        return redirect()->route('customers.create_invoice');
         $invoice->save();
    }
    public function getCustomerName()
    {
       $this->customer = Customer::where('phone',$this->customer_phone)->first();
       if($this->customer != null) {
            $this->customer_name =  $this->customer->name_ar;
       } else{
        $this->dispatch(
            'alert',
            text: 'فضلا ادخل اسم العميل لتسجيله بقاعد البيانات',
            icon: 'error',
            confirmButtonText: trans('admin.done')
        );
       }

    }



    public function create()
    {
        //dd($this->all());
            $this->validate($this->rules() ,$this->messages());

        // try{
                DB::beginTransaction();

                //check customer in db
                $this->customer = Customer::where('phone',$this->customer_phone)->first();
                if($this->customer) {
                    $this->getCustomerName();
                } else {
                    if($this->customer_phone || $this->customer_name)  {

                        $currentChildAccountNum = 0;

                        $customersParentAccount = Account::where('name_ar',"العملاء")->first();

                        $latestAccountChild = Account::where('parent_id', $customersParentAccount->id)->latest()->first();
                        // dd($latestAccountChild);
                        if ($latestAccountChild) {
                                $currentChildAccountNum = $latestAccountChild->account_num;
                        } else {

                            $currentChildAccountNum = $customersParentAccount->account_num . '0';
                        }

                        // dd($currentChildAccountNum); 

                        $this->customer = new Customer();
                        $this->customer->name_ar = $this->customer_name;
                        $this->customer->phone = $this->customer_phone;
                        $this->customer->account_num = $currentChildAccountNum + 1;
                        $this->customer->balance_state = 1;
                        $this->customer->start_balance = 0;
                        $this->customer->current_balance = 0;
                        $this->customer->save();


                        $account = new Account();
                        $account->name_ar = $this->customer->name_ar;
            
                        $account->start_balance = 0;
                        $account->current_balance = 0;
                        $account->account_num = $this->customer->account_num;
                        $account->account_type_id = 6;
                        $account->nature = "مدين";
                        $account->list = "مركز-مالي";
                        $account->parent_id = $customersParentAccount->id;
                        $account->branch_id = $this->branch_id;
                        $account->created_by = Auth::user()->id;
                        $account->updated_by = Auth::user()->id;
                        $account->level = $customersParentAccount->level + 1;
                        $account->is_active = 1;
                        $account->is_parent = 0;
                        $account->save();
                    }

                }

                $this->invoice = new CustomerInvoice();

                $this->invoice->customer_inv_num = $this->customer_inv_num;
               // dd($this->invoice->customer_inv_num );
                $this->invoice->customer_inv_date_time = Carbon::parse($this->customerinv_date_time)->format('Y-m-d H:i:s');
                $this->invoice->is_pending  = $this->is_pending;
                $this->invoice->created_by = Auth::user()->id;
                // $this->invoice->payment_type = $this->payment_type;
                //$this->invoice->payment_method = $this->payment_method;
                $this->invoice->discount_percentage = $this->discount_percentage ? $this->discount_percentage : 0;
                // $this->invoice->customer_balance_before_invoice = customer::where('id',$this->customer_id)->first()->current_balance;
                $this->invoice->branch_id =Auth::user()->roles_name == 'سوبر-ادمن' ? $this->branch_id : Auth::user()->branch_id;;
                $this->invoice->customer_id = $this->customer->id ?? null;
                $this->invoice->created_by = Auth::user()->id;
                $this->invoice->type = 'sales';
                $this->invoice->save();

                $invTotal = 0;
                $taxTotal = 0;
                $commissionTotal=0;

                foreach ($this->rows as $index => $row) {
                    if($row['product_code'] != "")  {
                        // dd($row['qty']);
                        $product = Product::where('id', $row['product_id'] )->first();
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

                        $invTotal += $invoiceItem->total_without_tax;
                        $taxTotal += $invoiceItem->tax;
                        $commissionTotal += $invoiceItem->total_commission_rate;

                        //decrese inventory amount

                        //dd($oldInventory);
                        $oldInventory = 0;
                        if (Auth::user()->roles_name == 'سوبر-ادمن') {
                            $oldInventory  = Inventory::where('product_id', $row['product_id'] )->where('branch_id',$this->branch_id)->latest()->first();
                            //dd($oldInventory);
                        } else {
                            $oldInventory  = Inventory::where('product_id', $row['product_id'] )->where('branch_id',Auth::user()->branch_id)->latest()->first();
                            //dd($oldInventory);
                        }

                        $inventory = new Inventory();
                        $inventory->inventory_balance = $oldInventory ? $oldInventory->inventory_balance - $row['qty'] : $row['qty'];
                        $inventory->initial_balance = $oldInventory ? $oldInventory->initial_balance : 0;
                        $inventory->in_qty = 0;
                        $inventory->out_qty = $row['qty'];
                        $inventory->current_financial_year = date("Y");
                        $inventory->is_active = 1;
                        $inventory->branch_id = Auth::user()->branch_id;
                        $inventory->store_id = Auth::user()->branch->store->id;
                        $inventory->product_id = $row['product_id'];
                        $inventory->updated_by = Auth::user()->id;
                        $inventory->notes = 'مبيعات بالفرع';
                        $inventory->latest_purchase_price = $oldInventory->latest_purchase_price ?? null;
                        $inventory->latest_sale_price =  $invoiceItem->sale_price;
                        $inventory->inventorable_id = $this->invoice->id;
                        $inventory->inventorable_type = 'App\Models\CustomerInvoice';
                        $inventory->save();
                    }
                }

            //updates in customer_invoices table
            $discount = $invTotal * $this->discount_percentage / 100;
            $this->invoice->tax_value = $taxTotal ;
            $this->invoice->total_before_discount = $invTotal+$taxTotal ;
            $this->invoice->discount_percentage = $this->discount_percentage ;
            $this->invoice->total_after_discount = ($invTotal + $taxTotal)*(1- ($this->discount_percentage/100) );
            $this->invoice->total_commission_rate = $commissionTotal;
            $this->invoice->save();

            //dd($this->invoice->total_after_discount);



            $this->customer = Customer::where('phone',$this->customer_phone)->whereNot('phone',null)->first();
       
            if($this->customer) { 
                $pos = new PosTransaction();
                $pos->customer_id = $this->customer->id;
                $pos->old_points = $this->settings->percentage_for_pos * $this->invoice->total_after_discount /100;
                $pos->new_points = $this->settings->percentage_for_pos * $this->invoice->total_after_discount /100;
                $pos->expiry_date = Carbon::now()->addDays($this->settings->expiry_days);
                $pos->expired = 0;
                $pos->points_price = $this->settings->percentage_for_pos * $this->invoice->total_after_discount * $this->settings->point_price;
                $pos->type = 'add';
                $pos->save();

            }


            $this->clearInputs();



            // DB::commit();

            // $this->reset(['product_code','qty','product_name_ar','product_name_en','discount_value','discount_percentage']);



    //  } catch (Exception $e) {
    //         DB::rollback();
    //         return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
    //     }
    }



    public function render()
    {
        return view('livewire.customer-invoices.add-invoice');
    }
}

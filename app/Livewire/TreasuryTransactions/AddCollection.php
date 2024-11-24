<?php

namespace App\Livewire\TreasuryTransactions;

use Alert;
use Carbon\Carbon;
use App\Models\Account;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Treasury;
use App\Models\Transaction;
use App\Models\TreasuryShift;
use App\Models\PosTransaction;
use App\Models\CustomerInvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Events\AddCollectionWithEntry;
use App\Events\CustomerInvoiceInstallment;
use App\Events\NewTreasuryTransactionEvent;
use App\Livewire\Exchanges\DisplayExchanges;
use App\Events\NewTreasuryCollectionTransactionEvent;


class AddCollection extends Component
{
    public $invoice ,$customer_inv_num,$customer_id,$customer,$min_exchange_point=0, $reason ,$type,$receipt_amount_type ,$treasury,$account_type_id,$customerInvoice,$account_num ,$transaction_type_id ,$transactionable_type ,
    $transactionable_id,$date,$is_account,$treasury_shift_id,$receipt_amount,$deserved_account_amount,$debit,$credit,$debit_amount,$credit_amount,$branch_id,$invoice_deserved_amount,$description,$treasury_balance,$desiredSegment
    ,$pos,$posNum,$points_price=0,$points_to_exchange=0,$exchange_price=0,$settings,$is_available=0,$is_exchange,$paid,$remaining=0;

    public function mount($invoice)

    {

        $this->dispatch('newDebitCredit');

        $this->date = now()->format('Y-m-d');
        //dd($invoice);

        $previousUrl = url()->previous();
        $path = parse_url($previousUrl, PHP_URL_PATH);
        $segments = explode('/', $path);
        $this->desiredSegment = implode('/', array_slice($segments, 2,2));
       // dd($this->desiredSegment);
        //dd($this->desiredSegment);
        if ($this->desiredSegment == "customers/invoices") {
             //dd($this->invoice);
            $this->customer = $this->customer_id ? Customer::where('id',$this->invoice->customer_id)->first() : 0;
            //dd($this->customer);
            $this->settings = Setting::findOrFail(1);
            $this->pos = $this->customer ? number_format($this->customer->pos,2) : 0;
            // $this->point_price = $this->customer ?  $this->pos * $this->settings->point_price : 0;
            $this->min_exchange_point = $this->settings->min_exchange_pos;

            $this->invoice = $invoice;
            //d($this->invoice);

            $this->customer_inv_num = $this->invoice->customer_inv_num;
            $this->customer_id = $this->invoice->customer_id ?? null;
             $this->branch_id = $this->invoice->branch_id;
             //dd($this->branch_id);

            $this->transaction_type_id = 4;
            $this->transactionable_type = 'App\Models\CustomerInvoice';
            $this->transactionable_id = $this->customer_id;
            $this->is_account = 1;
            $this->account_type_id = 6;
            $this->type = "العميل";
            $this->receipt_amount_type = "المطلوب تحصيله من العميل";
            $this->reason =" مدفوعات لفاتورة  رقم " . $invoice->customer_inv_num;
            $this->deserved_account_amount = Customer::where('id',$this->customer_id)->first()->current_balance ?? null;
            $this->invoice_deserved_amount = number_format(($this->invoice->total_after_discount - $this->invoice->paid_amount),2);
            $this->receipt_amount = $this->invoice->total_after_discount - ($this->points_to_exchange * $this->settings->point_price ); 
            $this->description = "  تحصيل إيراد فاتورة مبيعات رقم $invoice->customer_inv_num ";
            $this->customer = Customer::where('id',$this->customer_id)->first();
            $this->account_num = $this->customer->account_num ?? null;

            $this->pos = PosTransaction::where('customer_id', $this->customer_id)->where('expiry_date','>=',Carbon::now())
            ->where('expired',0)->sum('new_points');
            $this->posNum = round($this->settings->percentage_for_pos * $this->invoice->total_after_discount /100);
            
            $this->is_available = $this->pos > $this->settings->min_exchange_pos ? 1 : 0;
            //dd($this->pos);

            $this->points_to_exchange = $this->posNum;

            $this->points_price =  number_format($this->posNum * $this->settings->point_price ,2);
            //dd($this->points_price);

        } elseif ($this->desiredSegment == "treasury/transactions") {

            $this->is_account = 0;
            $this->account_type_id = 6;
            $this->type = "العميل";
            $this->receipt_amount_type = "المطلوب تحصيله  ";
            $this->reason ="أخري";
        }





    }

    // calculator start المبلغ المدفوع
    public function addDigit($digit)
    {
        $this->paid .= $digit;
        $this->calculateRemaining();
    }

    public function clearInputs()
    {
    
        $this->paid = 0;
        $this->calculateRemaining();
  
    }

    public function clearQty()
    {
        $this->paid = "";
    }
    // calculator end المبلغ المدفوع

    public function rules() {

        return [
            'transaction_type_id' => 'required|exists:transaction_types,id',
            'receipt_amount' => 'required|numeric',
            'description' => 'required|string',
            'debit' => $this->desiredSegment != "customers/invoices" ? 'required' : '',
            'credit' => $this->desiredSegment != "customers/invoices" ? 'required' : '',
            'debit_amount' => $this->desiredSegment != "customers/invoices" ? 'required|numeric' : '',
            'credit_amount' => $this->desiredSegment != "customers/invoices" ? 'required|numeric' : '',
            'customer_phone' => 'required',

        ];

    }

    public function updatedDebit()
    {
        $this->dispatch('newDebitCredit');
    }

    public function updatedCredit()
    {
        $this->dispatch('newDebitCredit');
    }

    public function messages()
    {
        return [
            'receipt_amount.required' => 'مبلغ ايصال التحصيل مطلوب',
            'receipt_amount.numeric' =>'مبلغ ايصال التحصيل يجب أن يكون رقم',
            'transaction_type_id.required' => 'نوع الحركة المالية مطلوب',

            'description.string' => trans('validation.description_string'),
            'description.required' => 'سبب إيصال تحصيل النقدية مطلوب',
            'description.description_length' => trans('validation.description_length'),

            'debit.required' => 'حساب المدين مطلوب',
            'debit.exists' => 'حساب المدين الذي تم إدخاله غير موجود بقاعدة البيانات',

            'credit.required' => 'حساب الدائن مطلوب',
            'credit.exists' => 'حساب الدائن الذي تم إدخاله غير موجود بقاعدة البيانات',

            'debit_amount.required' => 'مبلغ المدين مطلوب',
            'debit_amount.numeric' => 'مبلغ المدين يجب أن يكون رقم',

            'credit_amount.required' => 'مبلغ الدائن مطلوب',
            'credit_amount.numeric' => 'مبلغ الدائن يجب أن يكون رقم',
        ];
    }

    public function recalculateReceiptAmount()
    {
            //dd($this->is_exchange);
        if($this->is_exchange == 1) {
           $this->receipt_amount  = number_format($this->invoice->total_after_discount - $this->points_price ,2);
        } elseif($this->is_exchange == false){
            $this->receipt_amount  = $this->invoice->total_after_discount;
        }

    }

    public function calculateRemaining(){
        // Make sure to cast to float before performing the operation
        $this->paid = (float) $this->paid; // Ensure paid is a float
        $this->receipt_amount = (float) $this->receipt_amount; // Ensure receipt_amount is a float
        $this->remaining = $this->paid - $this->receipt_amount;
    }


    public function saveWithoutPrint()
    {
        $this->create();
        if ($this->desiredSegment == "customers/invoices") {
            Alert::success('تم إضافة إيصال تحصيل مبيعات من العميل بنجاح');
            return redirect()->route('customers.invoices');
        }
        elseif($this->desiredSegment == "treasury/transactions"){
            Alert::success('تم إضافة إيصال التحصيل بنجاح');
            return redirect()->route('treasury.transactions');
        }

    }


    public function saveAndPrintReceipt() {

        $this->create();
           if ($this->desiredSegment == "customers/invoices") {
            Alert::success('تم إضافة إيصال تحصيل مبيعات من العميل بنجاح');
            return redirect()->route('customers.print_invoice',$this->invoice->customer_inv_num);
        }
        elseif($this->desiredSegment == "treasury/transactions"){
            Alert::success('تم إضافة إيصال التحصيل بنجاح');
            return redirect()->route('treasury.transactions');
        }

    }

    // public function recalculateReceiptAmount()
    // {
    //     $this->receipt_amount =  $this->is_exchange == 1 ? ($this->receipt_amount - $this->points_price)  : $this->receipt_amount ;
    // }


    public function create()
    {
        //$this->validate($this->rules() ,$this->messages());
        // try {
            DB::beginTransaction();
            if ($this->desiredSegment == "customers/invoices") {
                //dd("ll");
                if($this->invoice->payment_method == 'cash' && $this->invoice->payment_type == 'cash') {
                    $this->invoice->payment_method='cash';
                    $this->invoice->save();


                    $transaction = new Transaction();
                    $transaction->transaction_type_id = $this->transaction_type_id ;
                    $transaction->transactionable_type = $this->transactionable_type ;
                    $transaction->transactionable_id = $this->transactionable_id ;
                    $transaction->account_num = $this->account_num ;
                    $transaction->is_account = $this->is_account ;
                    $transaction->is_approved = 1;
                    $transaction->treasury_shift_id = Auth::user()->roles_name == 'سوبر-ادمن' ?TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->latest()->first()->id:TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',$this->branch_id)->latest()->first()->id;
                    $transaction->receipt_amount = $this->receipt_amount;
                    $transaction->deserved_account_amount = $this->receipt_amount;
                    $transaction->branch_id = $this->branch_id;
                    $transaction->treasury_id = Treasury::where('branch_id',$this->branch_id)->first()->id;
                    $transaction->description = $this->description == "" ? null : $this->description;
                    $transaction->serial_num = getNextTransSerial();
                    $transaction->inv_num = $this->customer_inv_num;
                    $transaction->date = $this->date ?$this->date  : Carbon::now() ;
                    $transaction->state = 'تحصيل';
                    // $transaction->account_type_id = 6;
                    $transaction->save();

                    // $invoice = CustomerInvoice::where('id',$this->invoice->id)->first();
                    // $invoice->paid_amount = $this->invoice->paid_amount + $this->receipt_amount;
                    // $invoice->save();




                    // $treasury->current_balance = $this->treasury->current_balance + $this->receipt_amount;
                    // $treasury->save();

                    // $treasuryAccount->current_balance = $this->treasury->current_balance + $this->receipt_amount;
                    // $treasuryAccount->save();


                    //dd($this->is_exchange);
                    //points tranactions
                    if ($this->is_exchange == 1 ){
                        //dd($this->points_to_exchange);

                        $availablePos= PosTransaction::where('customer_id', $this->customer_id)->where('expiry_date','>=',Carbon::now())
                        ->where('expired',0)->get();



                        // Iterate over the rows and update the points
                        foreach ($availablePos as $row) {
                            if ($this->points_to_exchange <= 0) {
                                break; // Exit the loop if all points have been exchanged
                            }

        

                            if ($row->new_points > $this->points_to_exchange) {
                               // dd("kk");
                                // If the row has enough points to cover the remaining points to exchange
                                $row->new_points =  $row->new_points - $this->points_to_exchange  ;
                                $row->save();
                                $this->points_to_exchange = 0;
                                
                            }  elseif ($row->new_points == $this->points_to_exchange) {
                                // If the row has enough points to cover the remaining points to exchange
                                //dd("ll");
                                $row->new_points = 0;
                                $row->expired = 1;
                                $row->save();
                                $this->points_to_exchange = 0;
                                
                            }else {
                                //dd("mm");
                                // If the row has fewer points than the remaining points to exchange
                                // $row->new_points = 0;
                                // $row->save();
                                $this->points_to_exchange -= $row->new_points;
                                $row->new_points = 0;
                                $row->expired = 1;
                                $row->save();
                            }
                        }


                    }

                    $invoice = $this->invoice;
                    $type = "CustomerInvoice";


                    $this->reset(['account_num','transaction_type_id','account_type_id','customer_id','receipt_amount','receipt_amount','deserved_account_amount','description',]);
                    //
                    event(new NewTreasuryCollectionTransactionEvent($transaction,$invoice,$type));
                    // Alert::success('تم إضافة إيصال تحصيل مبيعات من عميل بنجاح');
                    // return redirect()->route('customers.invoices');
                    DB::commit();
                } elseif($this->invoice->payment_method == null && $this->invoice->payment_type == 'by_installments') {

                    $this->invoice->payment_method = 'cash';
                    $this->invoice->save();
                    $this->treasury = Treasury::where('branch_id',$this->branch_id)->first();
                    //dd($this->treasury->current_balance);

                    $treasuryAccount = Account::where('account_num',$this->treasury->account_num)->first();
                    //dd($treasuryAccount);
                    if ($this->desiredSegment == "customers/invoices") {
                        $transaction = new Transaction();
                        $transaction->transaction_type_id = $this->transaction_type_id ;
                        $transaction->transactionable_type = $this->transactionable_type ;
                        $transaction->transactionable_id = $this->transactionable_id ;
                        $transaction->account_num = $this->account_num ;
                        $transaction->is_account = $this->is_account ;
                        $transaction->is_approved = 1;
                        $transaction->treasury_shift_id = Auth::user()->roles_name == 'سوبر-ادمن' ?
                            TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->latest()->first()->id:
                            TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',$this->branch_id)->latest()->first()->id;
                        $transaction->receipt_amount = $this->receipt_amount;
                        $transaction->deserved_account_amount = $this->receipt_amount;
                        $transaction->branch_id = $this->branch_id;
                        $transaction->treasury_id = $this->treasury->id;
                        $transaction->description = $this->description == "" ? null : $this->description;
                        $transaction->serial_num = getNextTransSerial();
                        $transaction->inv_num = $this->customer_inv_num;
                        $transaction->date = $this->date ?$this->date  : Carbon::now() ;
                        $transaction->state = 'تحصيل';
                        // $transaction->account_type_id = 6;
                        $transaction->save();

                        // $invoice = CustomerInvoice::where('id',$this->invoice->id)->first();
                        // $invoice->paid_amount = $this->invoice->paid_amount + $this->receipt_amount;
                        // $invoice->save();




                        // $treasury->current_balance = $this->treasury->current_balance + $this->receipt_amount;
                        // $treasury->save();

                        // $treasuryAccount->current_balance = $this->treasury->current_balance + $this->receipt_amount;
                        // $treasuryAccount->save();

                        $invoice = $this->invoice;
                        $type = "CustomerInvoice";


                        $this->reset(['account_num','transaction_type_id','account_type_id','customer_id','receipt_amount','receipt_amount','deserved_account_amount','description',]);
                        //
                        event(new NewTreasuryCollectionTransactionEvent($transaction,$invoice,$type));
                        // Alert::success('تم إضافة إيصال تحصيل مبيعات من عميل بنجاح');
                        // return redirect()->route('customers.invoices');

                        $invoice = $this->invoice;
                        $type = "CustomerInvoice";


                        $this->reset(['account_num','transaction_type_id','account_type_id','customer_id','receipt_amount','receipt_amount','deserved_account_amount','description',]);
                        //
                        event(new CustomerInvoiceInstallment($transaction,$invoice,$type));
                        DB::commit();
                    }
                }

            }
            else{

                $treasuryAccount = Account::where('id',$this->debit)->first();
                $selectedTrasury = Treasury::where('account_num',$treasuryAccount->account_num)->first();
                $this->validate($this->rules() ,$this->messages());
                //dd("kkk");
                $transaction = new Transaction();
                $transaction->transaction_type_id = $this->transaction_type_id ;
                $transaction->transactionable_type = $this->transactionable_type ;
                $transaction->transactionable_id = $this->transactionable_id ;
                $transaction->account_num = $this->account_num ;
                $transaction->is_account = 1 ;
                $transaction->is_approved = 1;
                $transaction->treasury_shift_id = Auth::user()->roles_name == 'سوبر-ادمن' ?
                    TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->latest()->first()->id:
                    TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',$this->branch_id)->latest()->first()->id;
                $transaction->receipt_amount = $this->receipt_amount;
                $transaction->deserved_account_amount = $this->receipt_amount;
                $transaction->branch_id = $this->branch_id;
                $transaction->treasury_id = $selectedTrasury->id;
                $transaction->description = $this->description == "" ? null : $this->description;
                $transaction->serial_num = getNextTransSerial();
                $transaction->inv_num = $this->customer_inv_num;
                $transaction->date = $this->date ?$this->date  : Carbon::now() ;
                $transaction->state = 'تحصيل';
                // $transaction->account_type_id = 6;
                $transaction->save();


                $type = "Transaction";


                $this->reset(['account_num','transaction_type_id','account_type_id','customer_id','receipt_amount','receipt_amount','deserved_account_amount','description',]);
                //
                event(new AddCollectionWithEntry($transaction,$type,$this->debit,$this->credit));
                // Alert::success('تم إضافة إيصال تحصيل مبيعات من عميل بنجاح');
                // return redirect()->route('customers.invoices');



                $this->reset(['account_num','transaction_type_id','account_type_id','customer_id','receipt_amount','receipt_amount','description','debit','credit','debit_amount','credit_amount','receipt_amount','deserved_account_amount']);
                //
                // event(new CustomerInvoiceInstallment($transaction,$invoice,$type));

                $selectedTrasury->update([
                    'current_balance' => $selectedTrasury->current_balance + $this->receipt_amount,
                ]);

                DB::commit();
                return redirect()->route('treasury.transactions');
                Alert::success('تم إضافة إيصال التحصيل  بنجاح');

                // event(new NewTreasuryCollectionTransactionEvent($transaction,$this->invoice,$type));
            }



        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }

    }

    public function render()
    {
        return view('livewire.treasury-transactions.add-collection');
    }
}

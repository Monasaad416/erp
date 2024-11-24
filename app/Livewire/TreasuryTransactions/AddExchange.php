<?php

namespace App\Livewire\TreasuryTransactions;

use Alert;
use Exception;
use Carbon\Carbon;
use App\Models\Branch;
use App\Models\Account;
use Livewire\Component;
use App\Models\Supplier;
use App\Models\TAccount;
use App\Models\Treasury;
use App\Models\ShiftType;
use App\Models\Transaction;
use App\Models\JournalEntry;
use App\Models\TreasuryShift;
use App\Models\SupplierInvoice;
use Illuminate\Support\Facades\DB;
use App\Events\AddExchangeWithEntry;
use Illuminate\Support\Facades\Auth;
use App\Events\AddCollectionWithEntry;
use App\Events\NewTreasuryTransactionEvent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddExchange extends Component
{

    public $invoice ,$supp_inv_num,$date,$supplier_id, $reason ,$type,$receipt_amount_type ,$treasury,$account_type_id,$supplierInvoice,$supplier,$account_num ,$transaction_type_id ,$transactionable_type ,
    $transactionable_id,$is_account,$treasury_shift_id,$receipt_amount,$debit,$credit,$debit_amount,$credit_amount,$deserved_account_amount,$branch_id,$invoice_deserved_amount=0,$description,$treasury_balance,$desiredSegment,$remaining_amount;

    public function mount($invoice)
    {
        $this->dispatch('newDebitCredit');

        try{
            $previousUrl = url()->previous();
            // $url = "http://pharma.test/ar/suppliers/invoices";
            $path = parse_url($previousUrl, PHP_URL_PATH);
            $segments = explode('/', $path);
            $this->desiredSegment = implode('/', array_slice($segments, 2));
            // dd($this->desiredSegment);
            if ($this->desiredSegment == "suppliers/invoices") {
                $this->invoice = $invoice;
                //dd($this->invoice);
                $this->supp_inv_num = $this->invoice->supp_inv_num;
                $this->supplier_id = $this->invoice->supplier_id;

                $this->transaction_type_id = 9;
                $this->transactionable_type = 'App\Models\Supplier';
                $this->transactionable_id = $this->supplier_id;
                $this->is_account = 1;
                $this->account_type_id = 7;
                $this->type = "المورد";
                $this->receipt_amount_type = "المطلوب دفعة للمورد";
                $this->reason =" مستحقات لفاتورة  رقم " . $invoice->supp_inv_num;
                $this->deserved_account_amount = Supplier::where('id',$this->supplier_id)->first()->current_balance;
                $this->invoice_deserved_amount =$this->invoice->total_after_discount - $this->invoice->paid_amount;
                $this->description = "إيصال صرف مستحقات للمورد عن فاتورة توريد رقم $invoice->supp_inv_num ";
                //dd( $this->invoice_deserved_amount);
                $this->supplier = Supplier::where('id',$this->supplier_id)->first();
                $this->account_num = $this->supplier->account_num;
                $this->remaining_amount = $this->invoice->total_after_discount - $this->invoice->paid_amount;
                
            } else{
                $chechSuperAdminShift = TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->latest()->first();

                    $currentTime = Carbon::now();
                    // $endTime = $currentTime->copy()->addHours($shift->total_hours);
                    //dd($currentTime->toTimeString(),$endTime->toTimeString());

                    $authUser = Auth::user();
           
                    $currentShift = TreasuryShift::whereTime('start_shift_date_time', '<=' , $currentTime)
                    ->whereTime('end_shift_date_time', '>=' , $currentTime)
                    ->where('user_id', $authUser->id)
                    ->latest()->first();
                    //dd($currentShift);
                    
   
   
                    if(!$currentShift){
                    $this->dispatch(
                    'alert',
                        text: trans('المستخدم الحالي ليس لديه ورديه خزينه مسجله'),
                        icon: 'error',
                        confirmButtonText: trans('admin.done')
                    );
                }
    
        
            }
 
        




            $authUser = Auth::user();
            $this->branch_id = $authUser->branch_id;
            $this->treasury = Treasury::where('branch_id' , $this->branch_id)->first();
            //dd($this->treasury);
            $this->treasury_balance = $this->treasury->current_balance;
            //dd($this->treasury_balance);
    
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }

    public function rules() {
        return [
            'transaction_type_id' => 'required|exists:transaction_types,id',
            'receipt_amount' => 'required|numeric',
            'description' => 'required|string',
            
            'debit' => $this->desiredSegment != "Suppliers/invoices" ? 'required' : '',
            'credit' => $this->desiredSegment != "Suppliers/invoices" ? 'required' : '',
            'debit_amount' => $this->desiredSegment != "Suppliers/invoices" ? 'required|numeric' : '',
            'credit_amount' => $this->desiredSegment != "Suppliers/invoices" ? 'required|numeric' : '',
            

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

            'receipt_amount.required' => 'مبلغ الإيصال مطلوب',
            'receipt_amount.numeric' => trans('validation.receipt_amount_string'),

            'description.string' => trans('validation.description_string'),
            'description.required' => 'سبب إيصال صرف النقدية مطلوب',
            'description.description_length' => trans('validation.description_length'),
            'transaction_type_id.required' => 'نوع الحركة المالية مطلوب',

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



    public function create()
    {
        $this->validate($this->rules() ,$this->messages());

        DB::beginTransaction();
        // try {



            if ($this->desiredSegment == "suppliers/invoices") {
                //dd( $this->receipt_amount);

                $this->treasury = Treasury::where('branch_id',$this->branch_id)->first();
                //dd($this->treasury->current_balance);

                $treasuryAccount = Account::where('account_num',$this->treasury->account_num)->first();
                if($this->receipt_amount < $this->remaining_amount && $this->receipt_amount < $this->treasury_balance && $this->receipt_amount < $this->deserved_account_amount && $this->receipt_amount < $this->invoice_deserved_amount){
                    //dd(TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',$this->branch_id)->latest()->first());
                 
                    $transaction = new Transaction();
                    $transaction->transaction_type_id = $this->transaction_type_id ;
                    $transaction->transactionable_type= $this->transactionable_type ;
                    $transaction->transactionable_id= $this->transactionable_id ;
                    $transaction->account_num= $this->account_num ;
                    $transaction->is_account=$this->is_account ;
                    $transaction->is_approved=1;
                    $transaction->treasury_shift_id= TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',$this->branch_id)->latest()->first()->id;
                    $transaction->receipt_amount=$this->receipt_amount;
                    $transaction->deserved_account_amount= $this->deserved_account_amount;
                    $transaction->branch_id = $this->branch_id;
                    $transaction->treasury_id = $this->treasury->id;
                    $transaction->description=$this->description == "" ? null : $this->description;
                    $transaction->serial_num = getNextTransSerial();
                    $transaction->inv_num = $this->supp_inv_num;
                    $transaction->date = $this->date ?$this->date  : Carbon::now() ; 
                    $transaction->save();

                    $suppInv = SupplierInvoice::where('id',$this->invoice->id)->first();
                    $supplier = Supplier::where('id',$this->supplier_id)->first();

                    $suppInv->paid_amount = $this->invoice->paid_amount + $this->receipt_amount;
                    $suppInv->save();

                    $this->remaining_amount = $suppInv->total_after_discount - $suppInv->paid_amount;
                    if ($this->remaining_amount <= 0) {
                        $suppInv->status = 2;
                        $suppInv->save();
                    } else {
                        $suppInv->status = 3;
                        $suppInv->save();
                    }

                    $supplier->current_balance = $this->supplier->current_balance - $this->receipt_amount;
                    $supplier->save();

                    
                    $this->treasury->current_balance = $this->treasury->current_balance - $this->receipt_amount;
                    $this->treasury->save();

                    $treasuryAccount->current_balance = $this->treasury->current_balance - $this->receipt_amount;
                    $treasuryAccount->save();

                    $invoice = $this->invoice;

             
                    event(new NewTreasuryTransactionEvent($transaction,$invoice));

                    $this->reset(['account_num','transaction_type_id','account_type_id','supplier_id','receipt_amount','deserved_account_amount','description',]);
                    Alert::success('تم إضافة إيصال دفع قسط الفاتورة بنجاح ');
                    return redirect()->route('suppliers.invoices');
                } else{
                    //dd($this->receipt_amount , $this->treasury_balance);
                    $this->dispatch(
                        'alert',
                            text: 'عفوا لايمكن اصدار إيصال صرف نقدية - فضلا راجع مبلغ الايصال ',
                            icon: 'error',
                            confirmButtonText: trans('admin.done')
                    );
                }
            }else{
               
                $treasuryAccount = Account::where('id',$this->credit)->first();
                $selectedTreasury = Treasury::where('account_num',$treasuryAccount->account_num)->first();
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
                $transaction->treasury_id = $selectedTreasury->id;
                $transaction->description = $this->description == "" ? null : $this->description;
                $transaction->serial_num = getNextTransSerial();
                $transaction->inv_num = null;
                $transaction->date = $this->date ?$this->date  : Carbon::now() ;
                $transaction->state = 'صرف';
                // $transaction->account_type_id = 6;
                $transaction->save();


                $type = "Transaction";


                $this->reset(['account_num','transaction_type_id','account_type_id','receipt_amount','receipt_amount','deserved_account_amount','description',]);
                //
                event(new AddExchangeWithEntry($transaction,$type,$this->debit,$this->credit));
                // Alert::success('تم إضافة إيصال تحصيل مبيعات من عميل بنجاح');
                // return redirect()->route('customers.invoices');



              
                // event(new CustomerInvoiceInstallment($transaction,$invoice,$type));


                Alert::success('تم إضافة إيصال التحصيل  بنجاح');
                DB::commit();
                return redirect()->route('treasury.transactions');
             
                
            }

            
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }

    }

    public function render()
    {
        return view('livewire.treasury-transactions.add-exchange');
    }
}

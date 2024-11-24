<?php

namespace App\Livewire\BankTransactions;

use Alert;
use Exception;
use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Account;
use Livewire\Component;
use App\Models\Supplier;
use App\Models\TAccount;
use App\Models\Treasury;
use App\Models\Transaction;
use App\Models\JournalEntry;
use App\Models\TreasuryShift;
use App\Models\BankTransaction;
use App\Models\SupplierInvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Events\NewBankTransactionEvent;
use App\Events\AddBankCollectionWithEntry;
use App\Events\NewTreasuryTransactionEvent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddExchangeTransaction extends Component
{

    public $invoice ,$supp_inv_num,$supplier_id, $reason ,$type,$amount_type ,$bank,$bank_id,$check_num,$account_type_id,$supplierInvoice,$supplier,$account_num ,$transaction_type_id ,$transactionable_type ,
    $transactionable_id,$is_account,$bank_shift_id,$amount,$deserved_account_amount,$branch_id,$invoice_deserved_amount=0,$description,$bank_balance,$desiredSegment,$remaining_amount;

    public function mount($invoice)
    {

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
                $this->amount_type = "المطلوب دفعة للمورد";
                $this->reason =" مستحقات لفاتورة  رقم " . $invoice->supp_inv_num;
                $this->deserved_account_amount = Supplier::where('id',$this->supplier_id)->first()->current_balance;
                $this->invoice_deserved_amount =$this->invoice->total_after_discount - $this->invoice->paid_amount;
                $this->description = "شيك صرف مستحقات للمورد عن فاتورة توريد رقم $invoice->supp_inv_num ";
                //dd( $this->invoice_deserved_amount);
                $this->supplier = Supplier::where('id',$this->supplier_id)->first();
                $this->account_num = $this->supplier->account_num;
                $this->remaining_amount = $this->invoice->total_after_discount - $this->invoice->paid_amount;
                $this->bank_id = $this->invoice->bank_id;
            }



            $authUser = Auth::user();
            $this->branch_id = $authUser->branch_id;
            $this->bank =  Bank::where('id' , $this->bank_id)->first();
            //dd($this->bank);
            $this->bank_balance = $this->bank->current_balance;
            //dd($this->bank_balance);


           
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }

    public function getAccountNum()
    {
        $supplier = Supplier::where('id',$this->supplier_id)->first();

        $this->account_num = $supplier->account_num;
        $this->deserved_account_amount = $supplier->current_balance;
    }
    public function getBankBalance()
    {
        $bank = Bank::where('id', $this->bank_id)->first();
        $this->bank_balance = $bank->current_balance;
    }

    public function rules() {
        return [
            'transaction_type_id' => 'required|exists:transaction_types,id',
            'amount' => 'required|numeric',
            'description' => 'required|string',
        ];
    }

    public function messages()
    {
        return [

            'amount.required' => 'مبلغ الشيك مطلوب',
            'amount.numeric' => trans('validation.amount_string'),

            'description.string' => trans('validation.description_string'),
            'description.required' => 'سبب شيك صرف النقدية مطلوب',
            'description.description_length' => trans('validation.description_length'),
        ];
    }



    public function create()
    {
        $this->validate($this->rules() ,$this->messages());


        // try {

            $bank = Bank::where('id',$this->bank_id)->first();
           //dd($bank);
            $bankAccount = Account::where('account_num',$bank->account_num)->first();

            if ($this->desiredSegment == "suppliers/invoices") {
                //dd( $this->amount);

                if($this->amount <= $this->remaining_amount && $this->amount <= $this->bank_balance && $this->amount <= $this->deserved_account_amount && $this->amount <= $this->invoice_deserved_amount){
                    //dd(TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',$this->branch_id)->latest()->first());
                    DB::beginTransaction();
                    $transaction = new BankTransaction();
                    $transaction->transaction_type_id = $this->transaction_type_id ;
                    $transaction->transactionable_type= $this->transactionable_type ;
                    $transaction->transactionable_id= $this->transactionable_id ;
                    $transaction->account_num= $this->account_num ;
                    $transaction->is_account=$this->is_account ;
                    $transaction->is_approved=1;
                    $transaction->is_confirmed=1;
                    $transaction->amount=$this->amount;
                    $transaction->deserved_account_amount= $this->deserved_account_amount;
                    $transaction->branch_id = $this->branch_id;
                    $transaction->bank_id = $this->bank_id;
                    $transaction->description=$this->description == "" ? null : $this->description;
                    $transaction->check_num = $this->check_num;
                    $transaction->inv_num = $this->supp_inv_num;
                    $transaction->save();

                    $suppInv = SupplierInvoice::where('id',$this->invoice->id)->first();
                    $supplier = Supplier::where('id',$this->supplier_id)->first();

                    $suppInv->paid_amount = $this->invoice->paid_amount + $this->amount;
                    $suppInv->save();

                    $this->remaining_amount = $suppInv->total_after_discount - $suppInv->paid_amount;
                    if ($this->remaining_amount <= 0) {
                        $suppInv->status = 2;
                        $suppInv->save();
                    } else {
                        $suppInv->status = 3;
                        $suppInv->save();
                    }

                    $invoice = $this->invoice;
                    $bank_id = $this->bank_id;

                    DB::commit();

                if($this->debit != null && $this->credits != null) {
                    event(new AddBankCollectionWithEntry($transaction, $type, $this->debit, $this->credit));
                } else {
                    event(new NewBankTransactionEvent($transaction,$invoice,$bank_id));
                }
                    $this->reset(['account_num','transaction_type_id','account_type_id','supplier_id','amount','deserved_account_amount','description',]);
                    Alert::success('تم إضافة شيك دفع قسط الفاتورة بنجاح ');
                    return redirect()->route('suppliers.invoices');
                } else{
                    //dd($this->amount , $this->bank_balance);
                    $this->dispatch(
                        'alert',
                            text: 'عفوا لايمكن اصدار شيك صرف نقدية - فضلا راجع مبلغ الايصال ',
                            icon: 'error',
                            confirmButtonText: trans('admin.done')
                    );
                }
            }elseif($this->desiredSegment == "bank/transactions"){
                if($this->amount <= $this->bank_balance && $this->amount <= $this->deserved_account_amount && $this->amount <= $this->invoice_deserved_amount){
                    DB::beginTransaction();

                    $transaction = new Transaction();
                    $transaction->transaction_type_id = $this->transaction_type_id ;
                    $transaction->account_num =  $this->account_num ;
                    $transaction->is_account = 0;
                    $transaction->is_approved = 1;
                    $transaction->bank_shift_id = TreasuryShift::where('user_id',Auth::user()->id)->where('branch_id',$this->branch_id)->latest()->first()->id;
                    $transaction->amount = $this->amount;
                    $transaction->deserved_account_amount = 0;
                    $transaction->branch_id = $this->branch_id;
                    $transaction->bank_id = $this->bank->id;
                    $transaction->description = $this->description == "" ? null : $this->description;
                    $transaction->serial_num = $this->getNextTransSerial();
                    $transaction->date = Carbon::now();
                    $transaction->save();




                    $this->reset(['transaction_type_id','amount','description',]);

                    DB::commit();
                    event(new NewTreasuryTransactionEvent($transaction));

                    Alert::success('تم إضافة شيك الدفع بنجاح ');
                    return redirect()->route('suppliers.invoices');

                } else{
                    //dd($this->amount , $this->bank_balance);
                    $this->dispatch(
                        'alert',
                            text: 'عفوا لايمكن اصدار شيك صرف نقدية - فضلا راجع مبلغ الايصال   ',
                            icon: 'error',
                            confirmButtonText: trans('admin.done')
                    );
                }
            }


        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }

    }

    public function render()
    {
        return view('livewire.bank-transactions.add-exchange-transaction');
    }
}

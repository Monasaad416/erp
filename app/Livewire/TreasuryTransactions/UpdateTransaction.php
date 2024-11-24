<?php

namespace App\Livewire\TreasuryTransactions;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Treasury;
use App\Models\Transaction;
use App\Models\SupplierInvoice;

class UpdateTransaction extends Component
{
    protected $listeners = ['updateTransaction'];

   public $invoice ,$customer_inv_num,$supp_inv_num,$customer_id,$supplier_id,$customer,$pos=0, $reason ,$type,$receipt_amount_type ,$treasury,$account_type_id,$customerInvoice,$account_num ,$transaction_type_id ,$transactionable_type ,
    $transactionable_id,$is_account,$treasury_shift_id,$supplier,$receipt_amount,$deserved_account_amount,$branch_id,$invoice_deserved_amount,$description,$treasury_balance,$desiredSegment,
    $transaction,$state;

    public function updateTransaction($id) {
        $this->transaction = Transaction::findOrFail($id);
        $this->state = $this->transaction->state;
        $this->transaction_type_id = $this->transaction->tranaction_type_id;
        //dd($this->transaction->transaction_type_id);
        $this->is_account = $this->transaction->is_account;
        $supplirsTransactions = Transaction::where('transactionable_type', 'App\Models\Supplier')->pluck('transactionable_id')->toArray();
        $customersTransactions = Transaction::where('transactionable_type', 'App\Models\Customer')->pluck('transactionable_id')->toArray();
        $this->supplier = Supplier::whereIn('id',$supplirsTransactions)->where('id',$this->transaction->transactionable_id)->first();
        $this->customer = Customer::whereIn('id',$customersTransactions)->where('id',$this->transaction->transactionable_id)->first();;
        $this->transaction_type_id = $this->transaction->transaction_type_id;
        $this->account_num = $this->transaction->account_num;

        if($this->supplier != null){
        //dd("sss");
            $this->account_type_id = 7;
            $this->type = "المورد";
            $this->supp_inv_num = $this->transaction->inv_num;
            $this->supplier_id = $this->supplier->id;
        } elseif($this->customer != null){
                $this->account_type_id = 6;
                $this->type = "العميل";
                $this->customer_inv_num = $this->transaction->inv_num;
                $this->customer_id = $this->customer->id;
        } else {
            
        }
        $this->transaction_type_id = $this->transaction->transaction_type_id;


        $this->treasury = Treasury::where('id',$this->transaction->treasury_id)->first();
        $this->treasury_balance = $this->treasury->current_balance;
        $this->receipt_amount = $this->transaction->receipt_amount;
        $this->deserved_account_amount = $this->transaction->deserved_account_amount;
     
        //dd( $this->treasury);


        $this->resetValidation();

        $this->dispatch('editModalToggle');

    }

    public function update ()
    {
        //dd($this->supp_inv_num);
        if($this->supplier != null) {
            $transaction = Transaction::where('serial_num', $this->transaction->serial_num)->first();
            $oldReceiptAmount = $transaction->receipt_amount;
            //dd($oldReceiptAmount);

            $suppInvoice = SupplierInvoice::where('supplier_id', $this->supplier_id)->where('supp_inv_num',$this->supp_inv_num)->first();
            //dd($suppInvoice);
            $suppInvoice->paid_amount = $suppInvoice->paid_amount - $oldReceiptAmount + $this->receipt_amount;
            $suppInvoice->save();

            $supplier = Supplier::where('id', $this->supplier_id)->first();
            $supplier->current_balance = $supplier->current_balance - $oldReceiptAmount + $this->receipt_amount;
            $supplier->save();

            $transaction = Transaction::where('serial_num', $this->transaction->serial_num)->first();

            $transaction->receipt_amount =  $this->receipt_amount;
            $transaction->save();

            $treasury = Treasury::where('id', $this->transaction->treasury_id)->first();
            $treasury->current_balance = $treasury->current_balance + $oldReceiptAmount - $this->receipt_amount;
            $treasury->save();




        } elseif($this->customer != null) {

            $transaction = Transaction::where('serial_num', $this->transaction->serial_num)->first();
            $oldReceiptAmount = $transaction->receipt_amount;
            dd($oldReceiptAmount);

            $suppInvoice = SupplierInvoice::where('supplier_id', $this->supplier_id)->where('supp_inv_num',$this->supp_inv_num)->first();
            //dd($suppInvoice);
            $suppInvoice->paid_amount = $suppInvoice->paid_amount - $oldReceiptAmount + $this->receipt_amount;
            $suppInvoice->save();

            $supplier = Supplier::where('id', $this->supplier_id)->first();
            $supplier->current_balance = $supplier->current_balance - $oldReceiptAmount + $this->receipt_amount;
            $supplier->save();

            $transaction = Transaction::where('serial_num', $this->transaction->serial_num)->first();

            $transaction->receipt_amount =  $this->receipt_amount;
            $transaction->save();
        } else {
            $this->account_type_id = null;
        }

        $this->dispatch('editModalToggle');

        $this->dispatch('refreshData')->to(DisplayTransactions::class);

        $this->dispatch(
        'alert',
            text: trans('تم تعديل بيانات حركة الخزينة بنجاح'),
            icon: 'success',
            confirmButtonText: trans('admin.done')

        );
        

    }

    public function render()
    {
        return view('livewire.treasury-transactions.update-transaction');
    }
}

<?php

namespace App\Livewire\Banks;

use Exception;
use App\Models\Bank;
use App\Models\Account;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Alert;

class DeleteBank extends Component
{
        protected $listeners = ['deleteBank'];
    public $bank ,$bankName;

    public function deleteBank($id)
    {
        $this->bank = Bank::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('id',$id)->first();
         //dd($this->bank);
        $this->bankName = $this->bank->name;

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        // try{
            $bank = Bank::where('id',$this->bank->id)->first();
            // $account = Account::where('account_num',$this->bank->account_num)->first();

            // $account->delete();
            $bank->delete();


            $this->dispatch('deleteModalToggle');

            $this->dispatch('refreshData')->to(DisplayBanks::class);
                Alert::success( 'تم حذف البنك وحسابة من الشجرة المحاسبية بنجاح');
                return redirect()->route('banks');

        
        //     // }
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }


    }
    public function render()
    {
        return view('livewire.banks.delete-bank');
    }
}

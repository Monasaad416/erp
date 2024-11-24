<?php

namespace App\Livewire\Capitals;

use Exception;
use App\Models\Capital;
use Livewire\Component;
use Alert;

class DeleteCapital extends Component
{

    protected $listeners = ['deleteCapital'];
    public $capital ,$capitalPartner,$amount;

    public function deleteCapital($id)
    {
        $this->capital = Capital::where('id',$id)->first();
        $this->amount = $this->capital->amount;
        $this->capitalPartner = $this->capital->partner->name;

        $this->dispatch('deleteModalToggle');

    }

        public function delete()
    {
        try{
            $capital = Capital::where('id',$this->capital->id)->first()->delete();

            $this->reset('capital');

            $this->dispatch('deleteModalToggle');

            $this->dispatch('refreshData')->to(DisplayCapitals::class);

            // $this->dispatch(
            // 'alert',
            //     text: trans('admin.capital_deleted_successfully'),
            //     icon: 'success',
            //     confirmButtonText: trans('admin.done'),

            // );
            Alert::success('تم حذف بيانات رأس المال بنجاح');
            return redirect()->route('capitals');
        }catch (Exception $e) {
        return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
    }


    }
    public function render()
    {
        return view('livewire.capitals.delete-capital');
    }
}

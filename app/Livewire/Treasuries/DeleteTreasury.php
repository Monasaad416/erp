<?php

namespace App\Livewire\Treasuries;

use App\Models\Product;
use Livewire\Component;
use App\Models\Treasury;
use SebastianBergmann\Template\Exception;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Alert;


class DeleteTreasury extends Component
{
    protected $listeners = ['deleteTreasury'];
    public $treasury ,$treasuryName;

    public function deleteTreasury($id)
    {
        $this->treasury = Treasury::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('id',$id)->first();
        //dd($this->treasury);
        $this->treasuryName = $this->treasury->name;

        $this->dispatch('deleteModalToggle');


    }


    public function delete()
    {
        try{
            $treasury = Treasury::where('id',$this->treasury->id)->delete();
                $this->dispatch('deleteModalToggle');
                // $this->dispatch('refreshData')->to(DisplayTreasuries::class);
                // $this->dispatch(
                // 'alert',
                //     text: 'تم حذف الخزينة بنجاح',
                //     icon: 'success',
                //     confirmButtonText: trans('admin.done'),
                // );

                Alert::success('تم حذف الخزينة بنجاح');
                return redirect()->route('treasuries');

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }
    public function render()
    {
        return view('livewire.treasuries.delete-treasury');
    }
}


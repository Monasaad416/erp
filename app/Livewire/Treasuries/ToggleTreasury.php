<?php

namespace App\Livewire\Treasuries;

use Exception;
use Livewire\Component;
use App\Models\Treasury;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Toggletreasury extends Component
{
    public $id,$treasury ,$is_active,$treasuryName;
    protected $listeners = ['toggletreasury'];
    public function toggletreasury($id)
    {
        $this->id = $id;
        $this->treasury = Treasury::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','is_active')->where('id',$id)->first();

        $this->treasuryName = $this->treasury->name;
        // return dd($this->treasury);
        $this->is_active = $this->treasury->is_active;


        $this->dispatch('changeStateModalToggle');
    }


    public function toggle()
    {
        try{
            if( $this->treasury->is_active == 1 ){
                $this->treasury->is_active = 0;
                $this->treasury->save();
            }else {
                $this->treasury->is_active = 1;
                $this->treasury->save();
            }
            $this->dispatch('changeStateModalToggle');

            $this->dispatch('refreshData')->to(DisplayTreasuries::class);

            $this->dispatch(
            'alert',
                text: 'تم تغيير حالة التفعيل للخزينة بنجاح',
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {
        return view('livewire.treasuries.toggle-treasury',['treasury' => $this->treasury]);
    }
}

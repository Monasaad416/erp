<?php

namespace App\Livewire\ShiftsTypes;

use Exception;
use Livewire\Component;
use App\Models\shift;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ToggleShiftType extends Component
{
    public $id,$shift ,$is_active,$shiftName;
    protected $listeners = ['toggleshift'];
    public function toggleshift($id)
    {
        $this->id = $id;
        $this->shift = shift::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','is_active')->where('id',$id)->first();

        $this->shiftName = $this->shift->name;
        // return dd($this->shift);
        $this->is_active = $this->shift->is_active;


        $this->dispatch('changeStateModalToggle');
    }


    public function toggle()
    {
        try{
            if( $this->shift->is_active == 1 ){
                $this->shift->is_active = 0;
                $this->shift->save();
            }else {
                $this->shift->is_active = 1;
                $this->shift->save();
            }
            $this->dispatch('changeStateModalToggle');

            $this->dispatch('refreshData')->to(DisplayCategories::class);

            $this->dispatch(
            'alert',
                text: trans('admin.shift_state_changed_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {
        return view('livewire.shifts-types.toggle-shift-type',['shift' => $this->shift]);
    }
}

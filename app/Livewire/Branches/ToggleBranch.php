<?php

namespace App\Livewire\Branches;

use Exception;
use Livewire\Component;
use App\Models\Branch;

class ToggleBranch extends Component
{
    public $id,$branch;

    protected $listeners = ['toggleBranch'];

    public function toggleBranch($id)
    {
        $this->id = $id;
        $this->branch = Branch::findOrFail($id);
        //dd($this->branch->is_active);

        $this->resetValidation();

        //dispatch browser events (js)
        //add event to toggle toggle modal after save
        $this->dispatch('changeStateModalToggle');
    }


    public function toggle()
    {
        // dd($this->branch);
        try{
            if( $this->branch->is_active == 1 ){
                //dd('ff');
                $this->branch->is_active = 0;
                $this->branch->save();
            }else {
                $this->branch->is_active = 1;
                $this->branch->save();
            }

            $this->dispatch('changeStateModalToggle');

            $this->dispatch('refreshData')->to(DisplayBranches::class);

            $this->dispatch(
            'alert',
                text: trans('admin.branch_state_changed_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {

        return view('livewire.branches.toggle-branch',['branch' => $this->branch]);
    }
}

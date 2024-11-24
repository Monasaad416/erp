<?php

namespace App\Livewire\Branches;

use App\Models\Product;
use Livewire\Component;
use App\Models\Branch;
use SebastianBergmann\Template\Exception;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class DeleteBranch extends Component
{
    protected $listeners = ['deleteBranch'];
    public $branch ,$branchName;

    public function deleteBranch($id)
    {
        $this->branch = Branch::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('id',$id)->first();
        $this->branchName = $this->branch->name;

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try{
            $branch = Branch::where('id',$this->branch->id)->delete();
                        $this->dispatch('deleteModalToggle');

            $this->dispatch('refreshData')->to(DisplayBranches::class);

            $this->dispatch(
            'alert',
                text: trans('admin.branch_deleted_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done'),
            );

            // $products = Product::where('branch_id',$this->branch->id)->get();
            // if($products->count() > 0) {
            //     $this->dispatch('deleteModalToggle');
            //     $this->dispatch(
            //     'alert',
            //         text: trans('admin.cannot_delete_branch'),
            //         icon: 'error',
            //         confirmButtonText: trans('admin.done'),

            //     );
            // } else {
            //     $branch->delete();
            //     $this->reset('branch');
            //     $this->dispatch('deleteModalToggle');
            //     $this->dispatch('refreshData')->to(DisplayBranches::class);

            //     $this->dispatch(
            //     'alert',
            //         text: trans('admin.branch_deleted_successfully'),
            //         icon: 'success',
            //         confirmButtonText: trans('admin.done'),

            // );
            // }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }
    public function render()
    {
        return view('livewire.branches.delete-branch');
    }
}

